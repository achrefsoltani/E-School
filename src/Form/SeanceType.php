<?php

namespace App\Form;

use App\Entity\Personne;
use App\Entity\Seance;
use App\Repository\ClasseRepository;
use App\Repository\PersonneRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options['id'];
        $repos = $options['repo'];
        $en =$repos->ProfsClasse($id)->getQuery()->execute();
        $enseignants = $en[0]['enseignants'];

        $choices = [];
        foreach ($enseignants as $enseignant){

            array_push($choices,[''.$enseignant =>$enseignant]);
        };

        $builder
            ->add('Debut', DateTimeType::class, array(
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker',
                    'html5' => false,
                ],
            ))
            ->add('salle')

            ->add('profs',ChoiceType::class, [
                'required'=>true,
                'choices' => $choices,
                'multiple' => false,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
            'id'=>null,
            'repo'=>null
        ]);
    }
}
