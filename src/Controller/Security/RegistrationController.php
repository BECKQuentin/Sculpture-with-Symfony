<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\WebAuthenticator;
use App\Service\EmailService;
use App\Service\UploadService;
use Nzo\UrlEncryptorBundle\Encryptor\Encryptor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request, 
        UserPasswordEncoderInterface $passwordEncoder, 
        GuardAuthenticatorHandler $guardHandler, 
        WebAuthenticator $authenticator,
        EmailService $emailService,
        Encryptor $encryptor
        ): Response
    {
        
        if ($this->getUser()) {
            if($this->container->get('security.authorization_checker')->isGranted('ROLE_MEMBER')) {            
                return $this->redirectToRoute('redirect_user');   
            }                    
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setRoles(['ROLE_UNVERIFIED']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();            
            
            //Envoi mail
            $emailService->send([                
                'to' => $user->getEmail(), //if empty => adminEmail
                'subject' => 'Validez votre inscription',
                'template' => 'email/verify_email.html.twig',
                'context' => [
                    'user' => $user
                ],
            ]);

            $this->addFlash("success", "Vous êtes bien enregistré ! Merci de vérifier votre compte en cliquant sur le lien que nous vous avons envoyé par Email.");
            return $this->redirectToRoute('app_login');
            // return $guardHandler->authenticateUserAndHandleSuccess(
            //     $user,
            //     $request,
            //     $authenticator,
            //     'main' // firewall name in security.yaml
            // );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verification-email/{token}", name="verify_email")
     */
    public function verifyEmail(
        string $token, 
        Encryptor $encryptor, 
        UserRepository $userRepository,
        GuardAuthenticatorHandler $guardHandler,
        WebAuthenticator $authenticator,
        Request $request)
    {
        $id = $encryptor->decrypt($token);
        $user =$userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException("Votre compte n'a pas été trouvé");
        }

        $user->setEmailVerified(true);
        $user->setRoles(['MEMBER']);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main'
        );

        
    }
}