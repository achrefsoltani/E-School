<?php

namespace App\Controller;

use App\Entity\Personne;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/user/profile", name="profile")
     */
    public function redirectAction(): Response
    {
        return $this->render('profile/index.html.twig', [
            'user'=>$this->getUser(),
        ]);
    }
}
