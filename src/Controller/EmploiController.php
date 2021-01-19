<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmploiController extends AbstractController
{
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
