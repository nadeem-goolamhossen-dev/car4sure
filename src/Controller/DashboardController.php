<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/dashboard')]
#[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{
    /**
     * @var bool|null
     */
    private ?bool $isAdmin;

    public function __construct(Security $security)
    {
        $this->isAdmin = !is_null($security->getUser()) ?? in_array('ROLE_ADMIN', $security->getUser()->getRoles());
    }

    #[Route('/', name: 'app_dashboard', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('dashboard/dashboard.html.twig', [
            'title' => 'Dashboard',
            'activeMenu' => 'app_dashboard',
            'isAdmin' => $this->isAdmin,
        ]);
    }
}
