<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/news")
 */
class NewsController extends AbstractController
{
    /**
     * @Route("/", name="news_home", methods={"GET"})
     */
    public function home(NewsRepository $newsRepository): Response
    {
        return $this->render('news/home.html.twig', [
            'news' => $newsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/list", name="news_index", methods={"GET"})
     */
    public function index(NewsRepository $newsRepository): Response
    {
        return $this->render('news/index.html.twig', [
            'news' => $newsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="news_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileInfos = $form->get('image')->getData();
            $fileName = $fileInfos->getClientOriginalName();
            $newFileName = md5(uniqid()).$fileName;
            $fileInfos->move($this->getParameter('news_directory'),
                $newFileName);
            $news->setImage('uploads/news/'.$newFileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute('news_index');
        }

        return $this->render('news/new.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="news_show", methods={"GET"})
     */
    public function show(News $news): Response
    {
        return $this->render('news/show.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/{id}/activer", name="news_activer", methods={"GET"})
     */
    public function activer(NewsRepository $newsRepository ,News $news): Response
    {
        $news->setActive(!($news->getActive()));
        $this->getDoctrine()->getManager()->flush();
        return $this->render('news/home.html.twig', [
           'news' => $newsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="news_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, News $news): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileInfos = $form->get('image')->getData();
            if ($fileInfos) {
                $fileName = $fileInfos->getClientOriginalName();
                $newFileName = md5(uniqid()).$fileName;
                $fileInfos->move($this->getParameter('news_directory'),
                    $newFileName);
                $news->setContenu('uploads/cours/'.$newFileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('news_index');
        }

        return $this->render('news/edit.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="news_delete", methods={"DELETE"})
     */
    public function delete(Request $request, News $news): Response
    {
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($news);
            $entityManager->flush();
        }

        return $this->redirectToRoute('news_index');
    }
}
