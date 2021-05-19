<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\ClientMessage;
use App\Entity\Images;
use App\Entity\Materials;
use App\Entity\User;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\Repository\ClientMessageRepository;
use App\Repository\UserRepository;
use App\Service\UploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    /**
    * @Route("/admin", name="admin")
    */
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('member/view.html.twig', [
            'user' => $user
        ]);
    }  
    /**
    * @Route("/member-listing", name="member_listing")
    * @IsGranted("ROLE_ADMIN", message="Seules les ADMINS peuvent faire ça")
    */
    public function memberListing(Request $request, UserRepository $userRepository): Response
    {
        
        return $this->render('listing/members.html.twig', [
            'members' => $userRepository->userSearch($this->getUser(), $request->request->all())
        ]);     
    }

    /**
    * @Route("/delete-member/{id}", name="delete_member")
    * @IsGranted("ROLE_ADMIN", message="Seules les ADMINS peuvent faire ça")
    */
    public function deleteMember(User $user): Response
    {
        $em = $this->getDoctrine()->getManager();        
        $em->remove($user);
        $em->flush();        
        
        $this->addFlash('danger', "Vous avez supprimé ".$user->getName()." - ".$user->getEmail()." !");
        return $this->redirectToRoute('member_listing');
    }

    /**
     * @Route("/add-article", name="add_article")
     * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
     */
    public function addArticle(Request $request, UploadService $uploadService)
    {
        $article = new Article();
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $images = $form->get('images')->getData();            
            
            if ($images) {
                foreach ($images as $image) {
                    $fileName = $uploadService->uploadImages($image, $article); 
                    $img = new Images();                    
                    $img->setName($fileName);
                    $article->addImage($img);   
                }
            }

            // $materials = $form->get('materials')->getData();
            // if($materials) {
            //     foreach ($materials as $material) {
            //         $material = new Materials();
            //         $article->addMaterial($material);
            //     }
            // }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', "L'article a bien été ajoutée");
            return $this->redirectToRoute('articles_listing');
        }

        return $this->render('admin/add_article.html.twig', [
            'form' => $form->createView(),
            'articles' => $article
        ]);
    }

    /**
    * @Route("/articles-listing", name="articles_listing")
    * @IsGranted("ROLE_ADMIN", message="Seules les ADMINS peuvent faire ça")
    */
    public function articlesListing(ArticleRepository $articleRepository, Request $request ): Response
    {
    
        return $this->render('listing/articles.html.twig', [
            'articles' => $articleRepository->articleSearch($request->request->all())
        ]);     
    }

    /**
    * @Route("/delete-article/{id}", name="delete_article")
    * @IsGranted("ROLE_ADMIN", message="Seules les ADMINS peuvent faire ça")
    */
    public function deleteArticle(Article $article): Response
    {        
        $em = $this->getDoctrine()->getManager();        
        $em->remove($article);
        $em->flush();        
        
        $this->addFlash('danger', "Vous avez supprimé ".$article->getTitle()."  !");
        return $this->redirectToRoute('articles_listing');
    }
    

    /**
    * @Route("/admin/update/{id}", name="update_article")
    * @IsGranted("ROLE_ADMIN", message="Seules les ADMINS peuvent faire ça")
    */
    public function memberUpdate(Article $article, Request $request, UploadService $uploadService)
    {     
        //delete old images
        $imagesRemoved = $article->getImages();    
        foreach ($imagesRemoved as $img) {
            $article->removeImage($img);
        }
        
        //update new infos
        $form = $this->createForm(ArticleFormType::class, $article);        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $images = $form->get('images')->getData();            
            
            if ($images) {
                foreach ($images as $image) {
                    $fileName = $uploadService->uploadImages($image, $article); 
                    $img = new Images();                    
                    $img->setName($fileName);
                    $article->addImage($img);   
                }
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', "Les modifications ont bien été sauvegardées !");
            return $this->redirectToRoute('articles_listing');
        }

        return $this->render('admin/add_article.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);
    } 

    /**
    * @Route("/messages-listing", name="messages_listing")
    * @IsGranted("ROLE_ADMIN", message="Seules les ADMINS peuvent faire ça")
    */
    public function clientMessageListing(ClientMessageRepository $clientMessageRepository, Request $request ): Response
    {   
        return $this->render('listing/messages.html.twig', [
            'messages' => $clientMessageRepository->findAll()
        ]);     
    }

    /**
    * @Route("/delete-message/{id}", name="delete_message")
    * @IsGranted("ROLE_ADMIN", message="Seules les ADMINS peuvent faire ça")
    */
    public function deleteMessage(ClientMessage $clientMessage): Response
    {        
        $em = $this->getDoctrine()->getManager();        
        $em->remove($clientMessage);
        $em->flush();        
        
        $this->addFlash('danger', "Vous avez supprimé un message !");
        return $this->redirectToRoute('messages_listing');
    }
      
}
