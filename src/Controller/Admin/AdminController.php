<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
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
    * @Route("/", name="admin")
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
        $articles = new Article();
        $form = $this->createForm(ArticleFormType::class, $articles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();

            if ($image) {
                $fileName = $uploadService->uploadImage($image, $articles);
                $articles->setImage($fileName);
            }            
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($articles);
            $em->flush();

            $this->addFlash('success', "L'article a bien été ajoutée");
            return $this->redirectToRoute('articles_listing');
        }

        return $this->render('admin/add_article.html.twig', [
            'form' => $form->createView(),
            'articles' => $articles
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
    public function memberUpdate(Article $article, Request $request)
    {     
        $form = $this->createForm(ArticleFormType::class, $article);
        // $form->remove('email')->remove('plainPassword')->remove('agreeTerms')->remove('submit');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
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
      
}