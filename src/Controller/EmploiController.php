<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmploiController extends AbstractController
{
    /**
     * @Route("/emploi", name="emploi")
     */
    public function index(ClasseRepository $classeRepository): Response
    {
        $classe = $classeRepository->find(1);
        $listeSeances = $classe->getSeances()->toArray();
        return $this->render('emploi/index.html.twig', [
            'controller_name' => 'EmploiController',
            'classe' => $classe ,
            'seances' => $listeSeances,
        ]);
    }
}
