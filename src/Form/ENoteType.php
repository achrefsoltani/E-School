<?php

namespace App\Form;

use App\Entity\Matiere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ENoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matieres', EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => 'nom',
                'multiple' => false,
                'expanded' => false,
            ])
        ->add('Chercher',SubmitType::class , [
        'attr' => [
            'class' => 'btn btn-success'
        ]
    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
