<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Materials;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description'
            ])
            ->add('weight', IntegerType::class, [
                'label' => 'Poids'  
            ])
            ->add('prix', MoneyType::class, [
                'label' => 'Prix'
            ])            
            ->add('materials', EntityType::class, [
                'class'=> Materials::class,
                'label' => 'Matériaux',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,                
            ])    
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom'
            ])
            ->add('images', FileType::class, [                
                'label' => 'Image',
                'multiple' => true,
                'mapped' => false,
                'required' => false           
            ])
            
           
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter un article',
                'attr' => [
                    'class' => 'btn-success btn-green mt-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class
        ]);
    }
}
