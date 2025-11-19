<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_COMPANY')]
final class CompanyDashboardController extends AbstractController
{
    #[Route('/company/dashboard', name: 'app_company_dashboard')]
    public function index(): Response
    {
        // Offres publiées par l'entreprise
        $offres = [
            [
                'title' => 'Développeur Web Junior',
                'published_date' => '2024-01-05',
                'candidates_count' => 12,
                'status' => 'active',
            ],
            [
                'title' => 'Assistant DevOps',
                'published_date' => '2024-01-10',
                'candidates_count' => 5,
                'status' => 'paused',
            ],
            [
                'title' => 'Intégrateur Front-End',
                'published_date' => '2024-01-18',
                'candidates_count' => 3,
                'status' => 'closed',
            ],
        ];

        // Candidatures reçues
        $candidatures = [
            [
                'student_name' => 'Marie Dupont',
                'stage_title' => 'Développeur Web Junior',
                'applied_date' => '2024-01-15',
                'status' => 'new',
            ],
            [
                'student_name' => 'Alex Martin',
                'stage_title' => 'Assistant DevOps',
                'applied_date' => '2024-01-16',
                'status' => 'in_review',
            ],
            [
                'student_name' => 'Sara Cohen',
                'stage_title' => 'Intégrateur Front-End',
                'applied_date' => '2024-01-20',
                'status' => 'accepted',
            ],
        ];

        // Petites stats pour les cards
        $offresActives = array_filter($offres, fn ($o) => $o['status'] === 'active');
        $nbOffresActives = count($offresActives);
        $nbCandidatures = count($candidatures);
        $nbCandidaturesANePasRater = count(array_filter($candidatures, fn ($c) => in_array($c['status'], ['new', 'in_review'], true)));

        return $this->render('company_dashboard/index.html.twig', [
            'offres' => $offres,
            'candidatures' => $candidatures,
            'nbOffresActives' => $nbOffresActives,
            'nbCandidatures' => $nbCandidatures,
            'nbCandidaturesATraiter' => $nbCandidaturesANePasRater,
        ]);
    }
}
