<?php

namespace App\Controller;

use App\Entity\Contacte;
use App\Form\ContacteType;
use App\Repository\ContacteRepository;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contacte")
 */
class ContacteController extends AbstractController
{
    /**
     * @Route("/", name="contacte_index", methods={"GET"})
     */
    public function index(ContacteRepository $contacteRepository): Response
    {
        return $this->render('contacte/index.html.twig', [
            'contactes' => $contacteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contacte_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $contacte = new Contacte();
        $form = $this->createForm(ContacteType::class, $contacte);
        $form->remove('personne');
        $form->remove('reponse');
        $form->remove('etat');
        $form->remove('emetteur');
        $form->handleRequest($request);
        $contacte->setEtat('En cours');
        $contacte->setEmetteur($this->getUser()->getPersonne());
        if ($form->isSubmitted() && $form->isValid()) {
            $dest = $form->get('distinataire')->getData();
            if ($dest) {
                $contacte->setPersonne($dest);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contacte);
            $entityManager->flush();

            return $this->redirectToRoute('contacte_index');
        }

        return $this->render('contacte/new.html.twig', [
            'contacte' => $contacte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contacte_show", methods={"GET"})
     */
    public function show(Contacte $contacte): Response
    {
        return $this->render('contacte/show.html.twig', [
            'contacte' => $contacte,
        ]);
    }

    //show pour enseignant

    /**
     * @Route("/ens/{id}", name="list_message")
     */
    public function affiche($id)
    {
        $repository = $this->getDoctrine()->getRepository(Contacte::class);
        $contacte = $repository->findBy(['personne'=>$id]);
        if ($contacte) {
            return $this->render('contacte/affmes.html.twig', [
                'contacte' => $contacte,
            ]);
        } else {
            $this->addFlash('danger', "vous n'avez pas des messages");
            //return $this->redirectToRoute('trouver_enfants');
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }

    }
    //show pour parent

    /**
     * @Route("/parent/{id}", name="mes_message")
     */
    public function afficheparent($id)
    {
        $repository = $this->getDoctrine()->getRepository(Contacte::class);
        $contacte = $repository->findBy(['emetteur'=>$id]);
        if ($contacte) {
            return $this->render('contacte/parentmes.html.twig', [
                'contacte' => $contacte,
            ]);
        } else {
            $this->addFlash('danger', "vous n'avez pas des messages");
            //return $this->redirectToRoute('trouver_enfants');
            return $this->redirectToRoute('contacte_new');
        }

    }

    /**
     * @Route("/edit/{id}", name="contacte_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contacte $contacte): Response
    {

        $form = $this->createForm(ContacteType::class, $contacte);
        $form->remove('personne');
        $form->remove('distinataire');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contacte_index');
        }

        return $this->render('contacte/edit.html.twig', [
            'contacte' => $contacte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contacte_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contacte $contacte): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contacte->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contacte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contacte_index');
    }
}
