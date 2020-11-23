<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie',ChoiceType::class,
                ['choices' =>[
                    'Demande' => 'Demande',
                    'Réclamation' => 'Réclamation'
                ],
                ])
            ->add('objet')
            ->add('message')
            ->add('etat',ChoiceType::class,
                ['choices' =>[
                    'Ouverte' => 'Ouverte',
                    'En cours' => 'En cours',
                    'Traité' => 'Traité'

                ]


                ] )
            ->add('reponse')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
