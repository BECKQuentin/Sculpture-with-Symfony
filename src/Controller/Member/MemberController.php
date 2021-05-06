<?php

namespace App\Controller\Member;

use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class MemberController extends AbstractController
{
    /**
     * @Route("/member", name="member")
     * @IsGranted("ROLE_USER", message="Seules les membres peuvent faire ça")
     */
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render('member/view.html.twig', [
            'user' => $user
        ]);
    }
    /**
    * @Route("/member/update", name="member_update")
    * @IsGranted("ROLE_USER", message="Seules les membres peuvent faire ça")
    */
    public function memberUpdate(Request $request)
    {        
        $user = $this->getUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->remove('email')->remove('plainPassword')->remove('agreeTerms')->remove('submit');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "Les modifications ont bien été sauvegardées !");
            return $this->redirectToRoute('member_update', ['id' => $user->getId()]);
        }

        return $this->render('member/update.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}