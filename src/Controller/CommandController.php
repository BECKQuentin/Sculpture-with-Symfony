<?php

namespace App\Controller;

use App\Repository\CommandRepository;
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
        
        return $this->render('listing/commands.html.twig', [            
            'commands' => $commandRepository->findAll()
        ]);     
    }

    /**
    * @Route("/received-commands/{id}", name="received_command")
    * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
    */
    public function receivedCommand(): Response
    {
    
        return $this->redirectToRoute('commands_listing');           
    }

    /**
    * @Route("/progress-commands/{id}", name="progress_command")
    * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
    */
    public function progressCommand(): Response
    {
    
        return $this->redirectToRoute('commands_listing');           
    }

    /**
    * @Route("/delivery-commands/{id}", name="delivery_command")
    * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
    */
    public function deliveryCommand(): Response
    {
    
        return $this->redirectToRoute('commands_listing');           
    }

    /**
    * @Route("/delivered-commands/{id}", name="delivered_command")
    * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
    */
    public function ddeliveredCommand(): Response
    {
    
        return $this->redirectToRoute('commands_listing');           
    }
    

    
    
}
