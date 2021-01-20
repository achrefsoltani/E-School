<?php

namespace App\DataFixtures;

use App\Entity\Matiere;
use App\Entity\Personne;
use App\Entity\Salle;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
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
            for ($i = 0; $i < 10; $i++) {
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

                $user = new User();
                $user->setUsername($faker->userName);

                $user->setPassword($this->passwordEncoder->encodePassword($user,'secret'));
                if ($personne->getRole() == 'eleve'){
                    $user->setRoles(['ROLE_USER']);
                }else if ($personne->getRole() == 'parent'){
                    $user->setRoles(['ROLE_Parent']);
                }else if($personne->getRole() == 'enseignant'){
                    $user->setRoles(['ROLE_enseignant']);
                }else{
                    $user->setRoles(['ROLE_ADMIN']);
                }
                $user->setEmail($personne->getEmail());
                $personne->setUser($user);
                $manager->persist($user);
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
