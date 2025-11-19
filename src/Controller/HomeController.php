<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if ($this->getUser()) {
            // Redirection selon le rôle
            if ($this->isGranted('ROLE_STUDENT')) {
                return $this->redirectToRoute('app_student_dashboard');
            }
            if ($this->isGranted('ROLE_COMPANY')) {
                return $this->redirectToRoute('app_company_dashboard');
            }
        }

        // Visiteur non connecté : afficher la page d'accueil
        return $this->render('home/index.html.twig');
    }
}
