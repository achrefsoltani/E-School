<?php

namespace App\DataFixtures;

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
        for($i=0; $i < 300; $i++){
            $personne = new Personne();
            $sexe = $faker->boolean;
            if($sexe){
              $personne
                  ->setPrenom($faker->firstNameMale)
                  ->setSexe('male');
            }else{
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
                ->setRole($faker->randomElement(['eleve','parent','enseignant','admin']));
            if($personne->getRole() == 'eleve'){
                $personne->setDateNaissance($faker->dateTimeBetween('-20 years','-6 years'));
            }else{
                $personne->setDateNaissance($faker->dateTimeBetween('-80 years','-20 years'));
            }

            $manager->persist($personne);
        }
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
