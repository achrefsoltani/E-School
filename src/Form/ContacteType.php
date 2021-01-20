<?php

namespace App\Form;

use App\Entity\Contacte;
use App\Entity\Personne;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContacteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('distinataire', EntityType::class,[
                'class' => Personne::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->where("p.role='enseignant'");
                },
                'attr' => [
                    'class' => 'select2'
                ]
            ])
            ->add('objet')
            ->add('message',TextareaType::class)
            ->add('personne')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contacte::class,
        ]);
    }
}
