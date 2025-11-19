<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        // Si l'utilisateur est déjà connecté, le rediriger
        if ($this->getUser()) {
            // Redirection intelligente selon le rôle
            if ($this->isGranted('ROLE_STUDENT')) {
                return $this->redirectToRoute('app_student_dashboard');
            }
            if ($this->isGranted('ROLE_COMPANY')) {
                return $this->redirectToRoute('app_company_dashboard');
            }
            return $this->redirectToRoute('app_home');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // Hasher le mot de passe
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            // Définir la date de création
            $user->setCreatedAt(new \DateTimeImmutable());

            // Par défaut, l'utilisateur n'est pas vérifié
            $user->setIsVerified(false);

            // Sauvegarder l'utilisateur
            $entityManager->persist($user);
            $entityManager->flush();

            // Message de succès
            $this->addFlash('success', sprintf(
                'Bienvenue %s ! Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.',
                $user->getFirstName()
            ));

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
