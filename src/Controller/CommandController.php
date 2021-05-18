<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Command;
use App\Entity\User;
use App\Repository\CommandRepository;
use App\Repository\UserRepository;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CommandController extends AbstractController
{
    /**
     * @Route("/commands", name="commands_listing")
     * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
     */
    public function commands(CommandRepository $commandRepository, Request $request): Response
    {
        $commands = $commandRepository->findAll();
        $sum = null;
        foreach ($commands as $command) {
            $price = $command->getArticle()->getPrix();            
            $sum += $price; 
        }

        return $this->render('listing/commands.html.twig', [
            'commands' => $commands,
            'sum' => $sum
        ]);
    }

    /**
    * @Route("/confirm-command/{id}", name="confirm_command")
    */
    public function confirmCommand (Article $article): Response
    { 
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_MEMBER')) {
            
            $user = $this->getUser();
            return $this->render('command/confirmCommand.html.twig', [
                'article' => $article,
                'user' => $user
            ]);    
        } else {
            $this->addFlash('danger', 'Veuillez vous connecter ou vous inscrire');
            return $this->redirectToRoute('app_login');
        }           
       
    }
    

    /**
     * @Route("/command-article/{id}", name="command_article")
     */
    public function seeArticle(Article $article, EmailService $emailService): Response
    {
        $user = $this->getUser();

        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_MEMBER')) {

            $command = new Command;

            $command->setUser($this->getUser());
            $command->setArticle($article);
            $command->setStatus(['En attente']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($command);
            $em->flush();

            //Email de commande            
            $emailService->send([                
                'to' => $user->getEmail(), //if empty => adminEmail
                'subject' => 'Confirmation de commmande',
                'template' => 'email/command/confirmCommand.html.twig',
                'context' => [
                    'user' => $user,
                    'command' => $command,
                    'article' => $article,
                ],
            ]);

            $this->addFlash('success', 'Félicitations commande passée avec succès ! Un Email de confirmation vient de vous être envoyé ');
            return $this->redirectToRoute('member_commands');
        } else {
            $this->addFlash('danger', 'Veuillez vous connecter ou vous inscrire');
            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/received-command/{id}", name="received_command")
     * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
     */
    public function receivedCommand(Command $command): Response
    {
        $command->setStatus(['Reçu']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($command);
        $em->flush();

        $this->addFlash('success', 'Status mis à jour');
        return $this->redirectToRoute('commands_listing');
    }

    /**
     * @Route("/progress-command/{id}", name="progress_command")
     * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
     */
    public function progressCommand(Command $command): Response
    {
        $command->setStatus(['En cours de fabrication']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($command);
        $em->flush();

        $this->addFlash('success', 'Status mis à jour');
        return $this->redirectToRoute('commands_listing');
    }

    /**
     * @Route("/delivering-command/{id}", name="delivering_command")
     * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
     */
    public function deliveringCommand(Command $command): Response
    {
        $command->setStatus(['En livraison']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($command);
        $em->flush();

        $this->addFlash('success', 'Status mis à jour');
        return $this->redirectToRoute('commands_listing');
    }

    /**
     * @Route("/delivered-command/{id}", name="delivered_command")
     * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
     */
    public function deliveredCommand(Command $command): Response
    {
        $command->setStatus(['Livré']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($command);
        $em->flush();

        $this->addFlash('success', 'Status mis à jour');
        return $this->redirectToRoute('commands_listing');
    }

    /**
     * @Route("/delete-command/{id}", name="delete_command")
     */
    public function deleteCommand(Command $command): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($command);
        $em->flush();

        $this->addFlash('danger', "Commande supprimée avec succès !");

        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('commands_listing');
        } else if ($this->container->get('security.authorization_checker')->isGranted('ROLE_MEMBER')) {
            return $this->redirectToRoute('member_commands');
        }
    }
}
