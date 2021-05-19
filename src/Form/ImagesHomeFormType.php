<?php

namespace App\Form;

use App\Entity\ImagesHome;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImagesHomeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
            ])            
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',                
                'attr' => [
                    'class' => 'btn-primary mt-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImagesHome::class,
        ]);
    }
}
