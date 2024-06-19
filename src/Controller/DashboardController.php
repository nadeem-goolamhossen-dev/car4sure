<?php

namespace App\Controller;

use App\Service\Policy\PolicyManager;
use App\Service\Vehicle\VehicleManager;
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
     * @var PolicyManager
     */
    private PolicyManager $policyManager;

    /**
     * @var VehicleManager
     */
    private VehicleManager $vehicleManager;

    /**
     * @var bool Is admin
     */
    private bool $isAdmin = false;

    /**
     * Constructor
     *
     * @param Security $security
     * @param PolicyManager $policyManager
     * @param VehicleManager $vehicleManager
     */
    public function __construct(Security $security, PolicyManager $policyManager, VehicleManager $vehicleManager)
    {
        $this->policyManager = $policyManager;
        $this->vehicleManager = $vehicleManager;

        $this->isAdmin = $security->getUser() && in_array(
            'ROLE_ADMIN', $security->getUser()->getRoles()
        );
    }

    #[Route('/', name: 'app_dashboard', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('dashboard/dashboard.html.twig', [
            'title' => 'Dashboard',
            'activeMenu' => 'app_dashboard',
            'countPolicies' => $this->policyManager->getPoliciesCount(),
            'countVehicles' => $this->vehicleManager->getVehiclesCount(),
            'isAdmin' => $this->isAdmin,
        ]);
    }
}
