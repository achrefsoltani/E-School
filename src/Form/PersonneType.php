<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\Personne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
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
            ->add('adresse');
        if ($options['role'] == 'enseignant'){
            $builder->add('matieres',EntityType::class,[
                'class' => Matiere::class,
                'multiple' => true,
                'expanded' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
            'role' => null,
        ]);
    }
}
