<?php

namespace App\Controller;

use App\Entity\Policy;
use App\Form\PolicyType;
use App\Service\Policy\PolicyManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_USER', message: 'You are not allowed to view this page')]
class PolicyController extends AbstractController
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

    /**
     * Policies
     *
     * @throws Exception
     */
    #[Route('/dashboard/policies', name: 'app_dashboard_policies', methods: ['GET'])]
    public function index(PolicyManager $policyManager): Response
    {
        return $this->render('dashboard/policy/index.html.twig', [
            'title' => 'Policies',
            'activeMenu' => 'app_dashboard_policies',
            'policies' => $policyManager->getPolicies(),
            'isAdmin' => $this->isAdmin,
        ]);
    }

    /**
     * Create & edit policy
     *
     * @throws Exception
     */
    #[Route('/dashboard/policies/create', name: 'app_dashboard_policies_create', methods: ['GET', 'POST'])]
    #[Route('/dashboard/policies/{id}/edit', name: 'app_dashboard_policies_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ?Policy $policy, PolicyManager $policyManager): Response
    {
        $isNew = false;

        if (is_null($policy)) {
            $isNew = true;
            $policy = new Policy();
        }

        $form = $this->createForm(PolicyType::class, $policy);
        $form->handleRequest($request);

        // Form
        if ($form->isSubmitted() && $form->isValid()) {
            $policy = $form->getData();

            try {
                $policyManager->save($policy);
                $this->addFlash('Success', sprintf("The policy %s has been saved successfully",
                    str_pad($policy->getPolicyNo(), 10, '0', STR_PAD_LEFT)));

                return $this->redirectToRoute('app_dashboard_policies');
            } catch (Exception $e) {
                dd($e->getMessage());
                $this->addFlash('Error', sprintf("An error occured while saving the policy. [%s]", $e->getMessage
                ()));
            }
        }

        return $this->render('dashboard/policy/edit.html.twig', [
            'title' => 'Policies',
            'activeMenu' => 'app_dashboard_policies',
            'form' => $form->createView(),
            'isAdmin' => $this->isAdmin,
            'policy' => $isNew ? null : $policy
        ]);
    }

    /**
     * Delete policy
     *
     * @throws Exception
     */
    #[Route('/dashboard/policies/{id}/delete', name: 'app_dashboard_policies_delete', methods: ['DELETE'])]
    public function delete(Policy $policy,  PolicyManager $policyManager): JsonResponse
    {
        try {
            $policyManager->delete($policy);
        } catch (Exception $e) {
            $this->addFlash('Error', 'Unable to delete this policy');
            return $this->json(['success' => false]);
        }

        return $this->json(['success' => true]);
    }

    /**
     * Show policy
     *
     * @throws Exception
     */
    #[Route('/dashboard/policies/{id}/show', name: 'app_dashboard_policies_show', methods: ['GET'])]
    public function show(Policy $policy): Response
    {
        return $this->render('dashboard/policy/show.html.twig', [
            'title' => 'Policies',
            'activeMenu' => 'app_dashboard_policies',
            'isAdmin' => $this->isAdmin,
            'policy' => $policy
        ]);
    }
}
