<?php

namespace App\DataFixtures;

use App\Entity\Matiere;
use App\Entity\Personne;
use App\Entity\Salle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create("fr_FR");
        $list_matieres = ['arabe','francais','anglais','math','science','informatique','Education civique','Histoire','géographie'];
        // Creation des matieres
        foreach ($list_matieres as $mat) {
            $matiere = new Matiere();
            $matiere->setNom($mat)
                ->setCoefficient($faker->numberBetween(1,5));
            $manager->persist($matiere);

            // Creation des personnes:
            for ($i = 0; $i < 100; $i++) {
                $personne = new Personne();
                $sexe = $faker->boolean;
                if ($sexe) {
                    $personne
                        ->setPrenom($faker->firstNameMale)
                        ->setSexe('male');
                } else {
                    $personne
                        ->setPrenom($faker->firstNameFemale)
                        ->setSexe('female');
                }
                $personne
                    ->setNom($faker->lastName)
                    ->setLieuNaissance($faker->city)
                    ->setCin($faker->randomNumber(8))
                    ->setEmail($faker->email)
                    ->setNumTel($faker->randomNumber(8))
                    ->setAdresse($faker->address)
                    ->setLogin($faker->userName)
                    ->setMdp($faker->password)
                    ->setRole($faker->randomElement(['eleve', 'eleve', 'eleve', 'eleve', 'eleve', 'eleve', 'eleve', 'eleve', 'eleve', 'eleve', 'parent', 'parent', 'parent', 'parent', 'parent', 'enseignant', 'admin']));
                if ($personne->getRole() == 'eleve') {
                    $personne->setNiveau($faker->numberBetween(1, 10))
                        ->setDateNaissance($faker->dateTimeBetween('-20 years', '-6 years'));
                } elseif ($personne->getRole() == 'enseignant') {
                    $personne->setDateNaissance($faker->dateTimeBetween('-80 years', '-20 years'))
                        ->addMatiere($matiere);
                } else {
                    $personne->setDateNaissance($faker->dateTimeBetween('-80 years', '-20 years'));
                }
                $personne->setListMatieres($personne->getMatieres()->toArray());

                $manager->persist($personne);
            }
        }

        // Creation des salles
        for($i=0; $i < 30; $i++){
            $salle = new Salle();
            $salle->setNumero($i+1)
                ->setCapacite($faker->numberBetween(20,35))
                ->setCaracteristique($faker->text(20));
            $manager->persist($salle);
        }


        $manager->flush();
    }
}
