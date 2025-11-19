<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_STUDENT')]
final class StudentDashboardController extends AbstractController
{
    #[Route('/student/dashboard', name: 'app_student_dashboard')]
    public function index(): Response
    {
        $stages = [
            [
                'title' => 'Développeur Web Junior',
                'company' => 'TechStart',
                'location' => 'Lyon',
                'duration' => '3 mois',
            ],
            [
                'title' => 'Assistant DevOps',
                'company' => 'CloudCorp',
                'location' => 'Paris',
                'duration' => '6 mois',
            ],
            [
                'title' => 'Développeur PHP',
                'company' => 'WebFactory',
                'location' => 'Marseille',
                'duration' => '4 mois',
            ],
        ];

        $candidatures = [
            [
                'stage_title' => 'Développeur Web Junior',
                'company' => 'TechStart',
                'status' => 'En attente',
                'applied_date' => '2024-01-15',
            ],
            [
                'stage_title' => 'Assistant DevOps',
                'company' => 'CloudCorp',
                'status' => 'Refusée',
                'applied_date' => '2024-01-10',
            ],
        ];

        return $this->render('student_dashboard/index.html.twig', [
            'stages' => $stages,
            'candidatures' => $candidatures,
        ]);
    }
}
