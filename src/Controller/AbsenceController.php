<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Form\AbsenceType;
use App\Form\AbType;
use App\Repository\AbsenceRepository;
use App\Repository\PersonneRepository;
use App\Repository\SeanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/absence")
 */
class AbsenceController extends AbstractController
{
    /**
     * @Route("/", name="absence_index")
     */
    public function index(SeanceRepository $seanceRepository,Request $request): Response
    {
        $form = $this->createForm(AbType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = $form['Date']->getData();
        return $this->render('absence/index1.html.twig', [
            'absences' => $seanceRepository->findBy(['debut'=>$date]),
        ]);}
        return $this->render('absence/search.html.twig', [

            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/list", name="absence_index1")
     */
    public function list(SeanceRepository $seanceRepository,Request $request, AbsenceRepository $absenceRepository): Response
    {
        $form = $this->createForm(AbType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = $form['Date']->getData();
            $seance= $seanceRepository->findBy(['debut'=>$date]);
            return $this->render('absence/listE.html.twig', [
                'absences' => $absenceRepository->findBy(['seance'=>$seance]),
            ]);}
        return $this->render('absence/search.html.twig', [

            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/new/{idP}/{idS}", name="absence_new", methods={"GET","POST"})
     */
    public function new(Request $request,$idP, $idS, PersonneRepository $personneRepository, SeanceRepository $seanceRepository): Response
    {
        $absence = new Absence();
        $enseignant= $personneRepository->find($idP);
        $seance= $seanceRepository->find($idS);
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->remove('seance');
        $form->remove('personne');
        $absence->setSeance($seance);
        $absence->setPersonne($enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($absence);
            $entityManager->flush();

            return $this->redirectToRoute('absence_index');
        }

        return $this->render('absence/new.html.twig', [
            'absence' => $absence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="absence_show", methods={"GET"})
     */
    public function show(Absence $absence): Response
    {
        return $this->render('absence/show.html.twig', [
            'absence' => $absence,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="absence_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Absence $absence): Response
    {
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('absence_index');
        }

        return $this->render('absence/edit.html.twig', [
            'absence' => $absence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="absence_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Absence $absence): Response
    {
        if ($this->isCsrfTokenValid('delete'.$absence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($absence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('absence_index');
    }
}
