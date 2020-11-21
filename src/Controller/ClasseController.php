<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/classe")
 */
class ClasseController extends AbstractController
{
    /**
     * @Route("/", name="classe_index", methods={"GET"})
     */
    public function index(ClasseRepository $classeRepository): Response
    {
        return $this->render('classe/index.html.twig', [
            'classes' => $classeRepository->findAll(),
        ]);
    }



    /**
     * @Route("/niveau/{niveau}/new", name="classe_new", methods={"GET","POST"})
     */
    public function new(Request $request, int $niveau): Response
    {
        $classe = new Classe();
        $classe->setNiveau($niveau);
        $form = $this->createForm(ClasseType::class, $classe,['niv'=>$niveau]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $classe->setNbEleve(count($classe->getEleves()));
            $classe->setListMatieres($form['matieres']->getData()->toArray());
            foreach ($form['matieres']->getData() as $matiere){
                $classe->addMatiere($matiere);
            }
            foreach ($classe->getEleves() as $eleve){
                $classe->addMembre($eleve);
            }
            foreach ($classe->getEnseignants() as $enseignant){
                $classe->addMembre($enseignant);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classe);
            $entityManager->flush();

            return $this->redirectToRoute('classe_index');
        }

        return $this->render('classe/new.html.twig', [
            'classe' => $classe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/niveau", name="classe_niveau", methods={"GET"})
     */
    public function Niveau(): Response
    {

        return $this->render('classe/niveau.html.twig');

    }

    /**
     * @Route("/{id}", name="classe_show", methods={"GET"})
     */
    public function show(Classe $classe): Response
    {
        $list = $classe->getMembres()->toArray();



        usort($list, function($a, $b) {
            return $a->getNom() > $b->getNom() ? 1 : -1;
        });

        return $this->render('classe/show.html.twig', [
            'classe' => $classe,
            'eleves' => $list,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="classe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Classe $classe): Response
    {
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('classe_index');
        }

        return $this->render('classe/edit.html.twig', [
            'classe' => $classe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="classe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Classe $classe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($classe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_index');
    }


}
