<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\User\UserManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_ADMIN', message: 'You are not allowed to view this page')]
class UserController extends AbstractController
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
     * Users
     *
     * @throws Exception
     */
    #[Route('/dashboard/users', name: 'app_dashboard_users', methods: ['GET', 'POST'])]
    public function index(Request $request, UserManager $userManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // Form
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $userManager->save($form->getData());
                $this->addFlash('Success', sprintf("The user %s has been registered successfully",
                    $user->getFullname()));

                return $this->redirectToRoute('app_dashboard_users');
            } catch (Exception $e) {
                $this->addFlash('Error', sprintf("An error occured while registering the user. [%s]", $e->getMessage
                ()));
            }
        }

        return $this->render('dashboard/user/index.html.twig', [
            'title' => 'Users',
            'activeMenu' => 'app_dashboard_users',
            'form' => $form->createView(),
            'users' => $userManager->getUsers(),
            'isAdmin' => $this->isAdmin,
        ]);
    }
}
