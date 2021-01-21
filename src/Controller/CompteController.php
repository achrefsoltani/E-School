<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\User;
use App\Form\CompteType;
use App\Form\UserType;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/compte")
 */
class CompteController extends AbstractController
{
    /**
     * @Route("/new", name="compte")
     */
    public function creationCompte(Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(CompteType::class,$personne);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personne);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('personne/newcompte.html.twig', [
            'personne' => $personne,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/confirm", name="comfirm")
     */
    public function listCompte( PersonneRepository $personneRepository): Response
    {
        $user=Null;
        ;
        return $this->render('personne/confirmation.html.twig', [
            'personnes' => $personneRepository->findBy(['user'=>$user]),

        ]);
    }
    /**
     * @Route("/confirmation/{id}", name="comfirmation")
     */
    public function confirmationCompte($id,Request $request,PersonneRepository $personneRepository): Response
    {
        $personne=$personneRepository->find($id);
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->remove('personne');
        $form->remove('roles');
        $role[]= $personne->getRole();
        $user->setRoles($role);
        $user->setPersonne($personne);
        $personne->setUser($user);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($personne);
            $entityManager->flush();


            return $this->redirectToRoute('comfirm');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,

            'form' => $form->createView(),
        ]);
    }

}
