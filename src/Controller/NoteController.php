<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Note;
use App\Entity\Personne;
use App\Form\ENoteType;
use App\Form\NoteType;
use App\Repository\MatiereRepository;
use App\Repository\NoteRepository;
use App\Repository\PersonneRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/note")
 */
class NoteController extends AbstractController
{

    /**
     * @Route("/classeliste/{id}", name="classeliste")
     */
    public function note(Request $request,
                         Personne $enseignant = null, $id
    ) {
        if(!$enseignant)
            $enseignant = new Personne();
        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $enseignant = $repository->find($id);
        dd($enseignant);
        $classe = $enseignant->getClasse()->toArray();


        return $this->render('personne/listeClasse.html.twig', ['classes' => $classe]);

    }

    /**
     * @Route("/list/{id}", name="eleveliste", methods={"GET"})
     */
    public function list($id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Classe::class);
        $classe = $repository->find($id);
        $liste=  $classe->getMembres();

        return $this->render('note/list.html.twig', [
            'personnes' => $liste, 'classe'=>$classe,
            'role' => 'eleve'
        ]);
    }
    /**
     * @Route("/", name="note_index", methods={"GET"})
     */
    public function index(NoteRepository $noteRepository): Response
    {
        return $this->render('note/index.html.twig', [
            'notes' => $noteRepository->findAll(),
        ]);
    }
    /**
     * @Route("/modif/{id}", name="modifliste")
     */
    public function modif($id, Request $request, MatiereRepository $matiereRepository, NoteRepository  $noteRepository): Response
    {
        $form = $this->createForm(ENoteType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = $form['matieres']->getData();
            $idM= $matiereRepository->findBy(['nom'=>$date]);

            return $this->render('note/listeM.html.twig', [
                'notes' => $noteRepository->findBy(['eleve'=>$id, 'matiere'=> $date]),
            ]);

          //  return $this->redirectToRoute('note_index');
        }

        return $this->render('note/search.html.twig', [

            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new/{id}/{id1}", name="note_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id,$id1): Response
    {
        $repository1 = $this->getDoctrine()->getRepository(Classe::class);
        $classe = $repository1->find($id1);
        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $eleve = $repository->find($id);
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->remove('eleve');
        $form->remove('classe');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $note->setEleve($eleve);
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('eleveliste', ['id'=>$classe->getId()]);
        }

        return $this->render('note/new.html.twig', [
            'note' => $note,
            'classe'=> $classe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="note_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $eleve = $repository->find($id);
        $note = $eleve->getNotes();
        return $this->render('note/show.html.twig', [
            'notes' => $note
        ]);
    }

    /**
     * @Route("/{id}/edit", name="note_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Note $note): Response
    {
        $form = $this->createForm(NoteType::class, $note);
        $form->remove('eleve');
        $form->remove('classe');
        $form->remove('matiere');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modifliste', ['id'=>$note->getEleve()->getId()]);
        }

        return $this->render('note/edit.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="note_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Note $note): Response
    {
        if ($this->isCsrfTokenValid('delete'.$note->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($note);
            $entityManager->flush();
        }

        return $this->redirectToRoute('note_index');
    }
}
