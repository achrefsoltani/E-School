<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $niveau = $options['niv'];
        $builder
            ->add('nom')
            ->add('capacite')
            ->add('niveau')
            ->add('membres', EntityType::class, [
                'class' => Personne::class,
                'query_builder' => function(PersonneRepository $repo) use ($niveau) {
                        return $repo->createchoiceQueryBuilder($niveau);
                    },
                'group_by'=> function($choice, $key, $value){
                if ($choice->getRole() == 'eleve'){
                    return 'list des élèves:';
                }
                return 'list des enseignants';
                },
                'multiple' => true,
                'expanded' => false,

                ])

            ->add('matieres')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Classe::class,
            'niv' => '1',
        ]);
    }
}
