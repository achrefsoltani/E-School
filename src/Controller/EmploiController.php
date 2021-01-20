<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use App\Repository\PersonneRepository;
use App\Repository\SeanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmploiController extends AbstractController
{
    /**
     * @Route("/emploi/en/{id}", name="emploi_en")
     */
    public function index_en(SeanceRepository $seanceRepository, int $id): Response
    {

        $seances = $seanceRepository->findSeancesByProf($id)->getQuery()->execute();
        return $this->render('emploi/indexEn.html.twig', [
            'controller_name' => 'EmploiController',
            'seances' => $seances,
        ]);
    }

    /**
     * @Route("/emploi/{id}", name="emploi")
     */
    public function index(ClasseRepository $classeRepository, int $id): Response
    {

        $classe = $classeRepository->find($id);
        $listeSeances = $classe->getSeances()->toArray();

        return $this->render('emploi/index.html.twig', [
            'controller_name' => 'EmploiController',
            'classe' => $classe ,
            'seances' => $listeSeances,
        ]);
    }
}
