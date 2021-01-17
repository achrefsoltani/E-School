<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('sexe', ChoiceType::class,
                ['choices' =>[
                    'Male' => 'male',
                    'Female' => 'female'
                ],
                ])
            ->add('date_naissance', BirthdayType::class, [
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ]
            ])
            ->add('lieu_naissance')
            ->add('cin')
            ->add('email',EmailType::class)
            ->add('num_tel')
            ->add('adresse')
        ->add('role', ChoiceType::class,
        ['choices' =>[
            'Eleve' => 'Eleve',
            'Parent' => 'Parent',
            'Enseignant' => 'Enseignant'
        ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
