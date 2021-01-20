<?php

namespace App\Controller;

use App\Entity\Contacte;
use App\Form\ContacteType;
use App\Repository\ContacteRepository;
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
        $form->handleRequest($request);

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

    /**
     * @Route("/{id}/edit", name="contacte_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contacte $contacte): Response
    {
        $form = $this->createForm(ContacteType::class, $contacte);
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