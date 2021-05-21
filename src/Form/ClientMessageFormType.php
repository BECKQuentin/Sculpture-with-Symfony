<?php

namespace App\Form;

use App\Entity\ClientMessage;
use Gemonos\RecaptchaBundle\Type\RecaptchaSubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientMessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {                  
        $builder
            ->add('name', TextType::class, [
                'label' => 'Votre Prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre Nom'
            ])                    
            ->add('message', TextareaType::class, [
                'label' => 'Votre Message'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer votre message',
                'attr' => [
                    'class' => 'btn-primary mt-3'
                ]
            ])     
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {       
        $resolver->setDefaults([
            'data_class' => ClientMessage::class
        ]);
    }
}
