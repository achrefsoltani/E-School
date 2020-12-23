<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\Classe;
use App\Entity\Personne;
use App\Entity\Seance;
use App\Form\AbsenceetudiantType;
use App\Form\AbsenceType;
use App\Form\AbType;
use App\Form\EleveAbsenceType;
use App\Repository\AbsenceRepository;
use App\Repository\ClasseRepository;
use App\Repository\PersonneRepository;
use App\Repository\SalleRepository;
use App\Repository\SeanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/absence_etudiant")
 */
class AbsenceEtudiantController extends AbstractController
{
    /**
     * @Route("/", name="absence_etudiant_index")
     */
    public function index(SeanceRepository $seanceRepository,Request $request): Response
    {
        $form = $this->createForm(AbsenceetudiantType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $seance = $form['seance']->getData();


         return $this->render('absence_etudiant/index.html.twig',
             ['seances' => $seanceRepository->findby(['id'=>$seance]),
                ]
            );
         }
        return $this->render('absence_etudiant/search.html.twig', [

            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/nouveau/{idP}/{idS}", name="nouvelle_absence", methods={"GET","POST"})
     */
    public function new(Request $request,$idP, $idS, PersonneRepository $personneRepository, SeanceRepository $seanceRepository): Response
    {
        $absence = new Absence();
        $eleve= $personneRepository->find($idP);
        $seance= $seanceRepository->find($idS);
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->remove('seance');
        $form->remove('personne');
        $form->remove('Justifie');
        $absence->setSeance($seance);
        $absence->setPersonne($eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($absence);
            $entityManager->flush();

            return $this->redirectToRoute('consulter_absence',['id'=>$absence->getId()]);
        }

        return $this->render('absence_etudiant/nouveau.html.twig', [
            'absence' => $absence,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="consulter_absence", methods={"GET"})
     */
    public function show(Absence $absence): Response
    {

        return $this->render('absence_etudiant/show.html.twig', [
            'absence' => $absence,
        ]);
    }
    /**
     * @Route("/{id}/modifier", name="modifier_absence", methods={"GET","POST"})
     */
    public function edit(Request $request, Absence $absence): Response
    {
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->remove('seance');
        $form->remove('personne');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('absence_etudiant_index');
        }

        return $this->render('absence_etudiant/modifier.html.twig', [
            'absence' => $absence,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/absence/{id}", name="existance_absence")
     */
    public function findAbsenceByPersonne($id) {

        $repository= $this->getDoctrine()->getRepository(Absence::class);
            $absence=$repository->getAbsencewithIdPersonne($id);
        if ($absence) {
            return $this->render('absence_etudiant/supprimer.html.twig',['absence'=>$absence]);
        } else {
            $this->addFlash('danger', 'cette eleve na pas dabsence');
            return $this->redirectToRoute('absence_etudiant_index');
        }

    }
    /**
     * @Route("/supprimer/{id}/", name="supprimer_absence", methods={"DELETE","GET"})
     */
    public function delete(Request $request, Absence $absence): Response
    {
        if ($this->isCsrfTokenValid('delete'.$absence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($absence);
            $entityManager->flush();

        }else{
            $this->addFlash('error','le personne nexiste pas ');

        }

        return $this->redirectToRoute('absence_etudiant_index');
    }

    /**
     * @Route("/liste", name="liste_absence")
     */
    public function list(SeanceRepository $seanceRepository,Request $request, AbsenceRepository $absenceRepository): Response
    {
        $form = $this->createForm(AbType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = $form['Date']->getData();
            $seance= $seanceRepository->findBy(['debut'=>$date]);
            return $this->render('absence_etudiant/liste.html.twig', [
                'absences' => $absenceRepository->findBy(['seance'=>$seance]),
            ]);}
        return $this->render('absence_etudiant/search.html.twig', [

            'form' => $form->createView(),
        ]);

    }




}
