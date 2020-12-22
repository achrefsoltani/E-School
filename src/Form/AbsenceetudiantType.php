<?php

namespace App\Form;

use App\Entity\Seance;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbsenceetudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('seance',EntityType::class,[
                  'class'=>Seance::class,
               'query_builder'=>function (EntityRepository $er)
               {
                   return $er ->createQueryBuilder('j')
                       ->orderBy('j.classe','ASC');
               },
               'choice_label'=>'classe'
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
