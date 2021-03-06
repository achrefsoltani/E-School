<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Form\SeanceType;
use App\Repository\ClasseRepository;
use App\Repository\SeanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/seance")
 */
class SeanceController extends AbstractController
{
    /**
     * @Route("/", name="seance_index", methods={"GET"})
     */
    public function index(SeanceRepository $seanceRepository): Response
    {
        return $this->render('seance/index.html.twig', [
            'seances' => $seanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="seance_new", methods={"GET","POST"})
     */
    public function new(Request $request, int $id, ClasseRepository $classeRepository): Response
    {
        $seance = new Seance();
        $form = $this->createForm(SeanceType::class, $seance,array('id'=>$id, 'repo'=>$classeRepository));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classe = $classeRepository->find($id);
            $seance->setClasse($classe);
            $debut = clone $seance->getDebut();
            $seance->setFin($debut->modify('+2 hours'));


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($seance);

            $entityManager->flush();

            return $this->redirectToRoute('emploi',$parameters = ['id'=> $classe->getId()]);
        }

        return $this->render('seance/new.html.twig', [
            'seance' => $seance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="seance_show", methods={"GET"})
     */
    public function show(Seance $seance): Response
    {
        return $this->render('seance/show.html.twig', [
            'seance' => $seance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="seance_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Seance $seance): Response
    {
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('seance_index');
        }

        return $this->render('seance/edit.html.twig', [
            'seance' => $seance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="seance_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Seance $seance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($seance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('seance_index');
    }
}
