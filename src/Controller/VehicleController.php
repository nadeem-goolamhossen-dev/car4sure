<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Service\Vehicle\VehicleManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER', message: 'You are not allowed to view this page')]
class VehicleController extends AbstractController
{
    /**
     * @var bool|null
     */
    private ?bool $isAdmin;

    public function __construct(Security $security)
    {
        $this->isAdmin = $security->getUser() && in_array(
            'ROLE_ADMIN', $security->getUser()->getRoles()
        );
    }

    #[Route('/dashboard/vehicles', name: 'app_dashboard_vehicles', methods: ['GET'])]
    public function index(VehicleManager $vehicleManager): Response
    {
        return $this->render('dashboard/vehicle/index.html.twig', [
            'title' => 'Vehicles',
            'activeMenu' => 'app_dashboard_vehicles',
            'vehicles' => $vehicleManager->getVehicles(),
            'isAdmin' => $this->isAdmin,
        ]);
    }

    /**
     * Create & edit vehicle
     *
     * @throws Exception
     */
    #[Route('/dashboard/vehicles/create', name: 'app_dashboard_vehicles_create', methods: ['GET', 'POST'])]
    #[Route('/dashboard/vehicles/{id}/edit', name: 'app_dashboard_vehicles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ?Vehicle $vehicle, VehicleManager $vehicleManager): Response
    {
        $isNew = false;

        if (is_null($vehicle)) {
            $isNew = true;
            $vehicle = new Vehicle();
        }

        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        // Form
        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle = $form->getData();

            try {
                $vehicleManager->save($vehicle);
                $this->addFlash('Success', sprintf("The vehicle %s has been saved successfully", $vehicle->getVin()));

                return $this->redirectToRoute('app_dashboard_vehicles');
            } catch (Exception $e) {
                $this->addFlash('Error', sprintf("An error occured while saving the vehicle. [%s]", $e->getMessage
                ()));
                $this->redirectToRoute('app_dashboard_vehicles_create');
            }
        }

        return $this->render('dashboard/vehicle/edit.html.twig', [
            'title' => 'Vehicles',
            'activeMenu' => 'app_dashboard_vehicles',
            'form' => $form,
            'isAdmin' => $this->isAdmin,
            'vehicle' => $isNew ? null : $vehicle
        ]);
    }

    /**
     * Delete vehicle
     *
     * @throws Exception
     */
    #[Route('/dashboard/vehicles/{id}/delete', name: 'app_dashboard_vehicles_delete', methods: ['DELETE'])]
    public function delete(Request $request, Vehicle $vehicle,  VehicleManager $vehicleManager): JsonResponse
    {
        try {
            $vehicleManager->delete($vehicle);
        } catch (Exception $e) {
            $this->addFlash('Error', 'Unable to delete this vehicle');
            return $this->json(['success' => false]);
        }

        return $this->json(['success' => true]);
    }

    /**
     * Show vehicle
     *
     * @throws Exception
     */
    #[Route('/dashboard/vehicles/{id}/show', name: 'app_dashboard_vehicles_show', methods: ['GET'])]
    public function show(Vehicle $vehicle): Response
    {
        return $this->render('dashboard/vehicle/show.html.twig', [
            'title' => 'Vehicles',
            'activeMenu' => 'app_dashboard_vehicles',
            'isAdmin' => $this->isAdmin,
            'vehicle' => $vehicle
        ]);
    }
}
