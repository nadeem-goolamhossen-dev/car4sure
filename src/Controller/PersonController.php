<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Service\Person\PersonManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER', message: 'You are not allowed to view this page')]
class PersonController extends AbstractController
{
    /**
     * @var bool|null
     */
    private ?bool $isAdmin;

    public function __construct(Security $security)
    {
        $this->isAdmin = !is_null($security->getUser()) ?? in_array('ROLE_ADMIN', $security->getUser()->getRoles());
    }

    /**
     * Persons
     *
     * @param PersonManager $personManager
     *
     * @return Response
     */
    #[Route('/dashboard/person', name: 'app_dashboard_persons', methods: ['GET'])]
    public function index(PersonManager $personManager): Response
    {
        return $this->render('dashboard/person/index.html.twig', [
            'title' => 'Persons',
            'activeMenu' => 'app_dashboard_persons',
            'persons' => $personManager->getPersons(),
            'isAdmin' => $this->isAdmin,
        ]);
    }

    /**
     * Create & edit person
     *
     * @param Request $request
     * @param Person|null $person
     * @param PersonManager $personManager
     *
     * @return Response
     */
    #[Route('/dashboard/persons/create', name: 'app_dashboard_persons_create', methods: ['GET', 'POST'])]
    #[Route('/dashboard/persons/{id}/edit', name: 'app_dashboard_persons_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ?Person $person, PersonManager $personManager): Response
    {
        $isNew = false;

        if (is_null($person)) {
            $isNew = true;
            $person = new Person();
        }

        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();

            try {
                $personManager->save($person);
                $this->addFlash('Success', sprintf("The person %s has been saved successfully", $person->getFullname
                ()));

                return $this->redirectToRoute('app_dashboard_persons');
            } catch (Exception $e) {
                $this->addFlash('Error', sprintf("An error occured while saving the person. [%s]", $e->getMessage
                ()));
                $this->redirectToRoute('app_dashboard_persons_create');
            }
        }

        return $this->render('dashboard/person/edit.html.twig', [
            'title' => 'Persons',
            'activeMenu' => 'app_dashboard_persons',
            'form' => $form,
            'isAdmin' => $this->isAdmin,
            'person' => $isNew ? null : $person
        ]);
    }

    /**
     * Delete person
     *
     * @throws Exception
     */
    #[Route('/dashboard/persons/{id}/delete', name: 'app_dashboard_persons_delete', methods: ['DELETE'])]
    public function delete(Person $person,  PersonManager $personManager): JsonResponse
    {
        try {
            $personManager->delete($person);
        } catch (Exception $e) {
            $this->addFlash('Error', 'Unable to delete this person');
            return $this->json(['success' => false]);
        }

        return $this->json(['success' => true]);
    }

    /**
     * Show policy
     *
     * @throws Exception
     */
    #[Route('/dashboard/persons/{id}/show', name: 'app_dashboard_persons_show', methods: ['GET'])]
    public function show(Person $person): Response
    {
        return $this->render('dashboard/person/show.html.twig', [
            'title' => 'Persons',
            'activeMenu' => 'app_dashboard_persons',
            'isAdmin' => $this->isAdmin,
            'person' => $person
        ]);
    }
}
