<?php

namespace App\Controller;

use App\Entity\Personne;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesEnfantsController extends AbstractController
{
    /**
     * @Route("/mesenfants", name="mes_enfants")
     */
    public function index(): Response
    {
        return $this->render('mes_enfants/index.html.twig', [
            'controller_name' => 'MesEnfantsController',
        ]);
    }
    /**
     * @Route("/cin/{num?0}",name="trouver_enfants")
     */
    public function getPersonneBycin($num) {
        //$num=$this->getUser()->getPersonne()->getCin();
        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $personnes= $repository->getPersonnesBycinAndRole($num);
        return $this->render('mes_enfants/index.html.twig', [
            'personnes' => $personnes,
        ]);
    }

}
