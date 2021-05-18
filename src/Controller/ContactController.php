<?php

namespace App\Controller;

use App\Entity\ClientMessage;
use App\Form\ClientMessageFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
    /**
     * @Route("/contact-form", name="contact_form")
     */
    public function contactForm(Request $request): Response
    {
        $user =$this->getUser();
        $clientMessage = new ClientMessage();

        $form = $this->createForm(ClientMessageFormType::class, $clientMessage);

        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_MEMBER')) {            
            $clientMessage->setMember($user);
            $form->remove('name')->remove('lastname');
        } 

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($clientMessage);
            $em->flush();

            $this->addFlash('success', "Votre message à bien été envoyé !");
            return $this->redirectToRoute('home');
        }

        return $this->render('contact/contactMessage.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]); 
    }
}
