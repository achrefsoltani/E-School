<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Personne;
use App\Form\DemandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Pdemande")
 */
class ParentDController extends AbstractController
{
    /**
     * @Route("/{id}", name="demandeliste", methods={"GET"})
     */
    public function index1($id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $parent = $repository->find($id);
        $demande= $parent->getDemandes();
        return $this->render('demande/index1.html.tiwg', [
            'demandes' => $demande, 'parent'=>$parent,
        ]);
    }


    /**
     * @Route("/new/{id}", name="demande_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $parent = $repository->find($id);
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->remove('etat');
        $form->remove('reponse');
        $demande->setEtat('ouverte');
        $demande->setPersonne($parent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demande);
            $entityManager->flush();

            return $this->redirectToRoute('demandeliste', ['id'=>$parent->getId()]);
        }

        return $this->render('demande/new.html.twig', [
            'demande' => $demande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/showP/{id}", name="showParent", methods={"GET"})
     */
    public function showP(Demande $demande): Response
    {
        return $this->render('demande/showP.html.tiwg', [
            'demande' => $demande,
        ]);
    }

    /**
     * @Route("/{id}/{id1}/edit", name="pdemande_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Demande $demande,$id1): Response
    {
        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $parent = $repository->find($id1);
        $form = $this->createForm(DemandeType::class, $demande);
        $form->remove('etat');
        $form->remove('reponse');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demandeliste', ['id'=>$parent->getId()]);
        }

        return $this->render('demande/pEdit.html.twig', [
            'demande' => $demande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="demande_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Demande $demande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('demandeliste', ['id'=>$demande->getPersonne()->getId()]);
    }
}
