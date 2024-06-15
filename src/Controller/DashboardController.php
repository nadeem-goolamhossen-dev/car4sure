<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/dashboard')]
#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_USER")'))]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(Request $request): Response
    {
        return $this->render('dashboard/dashboard.html.twig', [
            'title' => 'Dashboard',
            'activeMenu' => 'app_dashboard',
        ]);
    }

    #[Route('/users', name: 'app_dashboard_users')]
    public function users(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // Form
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            //$data->isActive = $form->get('isActive')->getData();
            dd($data);
        }

        return $this->render('dashboard/users.html.twig', [
            'title' => 'Users',
            'activeMenu' => 'app_dashboard_users',
            'form' => $form->createView(),
            'users' => $userRepository->findAll(),
        ]);
    }
}
