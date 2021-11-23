<?php

namespace App\Form;

use App\Entity\Auteurs;
use App\Entity\Articles;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, ['label' => 'Titre ', 'required' => true])
            ->add('resume', TextType::class, ['label' => 'Résumé ', 'required' => true])
            ->add('contenu', TextType::class, ['label' => 'Contenu ', 'required' => true])
            ->add('date', DateType::class, ['label' => 'Date '])
            ->add('image', TextType::class, ['label' => 'Image ', 'required' => true])
            ->add('categories', EntityType::class, [
                // Label du champ    
                'label'  => 'Catégorie',
                //'placeholder' => 'Catégor_e',

                // looks for choices from this entity
                'class' => Categories::class,

                // Sur quelle propriete je fais le choix
                'choice_label' => 'categories',
                // used to render a select box, check boxes or radios
                //'multiple' => true,
                'expanded' => true,
            ])/*
            ->add('auteurs', EntityType::class, [
                // Label du champ    
                'label'  => 'Auteurs',
                //'placeholder' => 'Auteurs',

                // looks for choices from this entity
                'class' => Auteurs::class,

                // Sur quelle propriete je fais le choix
                'choice_label' => 'nom',
                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
            ])*/
            ->add('Enregistrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
