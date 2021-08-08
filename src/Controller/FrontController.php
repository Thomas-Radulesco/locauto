<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Form\ChangePasswordFormType;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @IsGranted("ROLE_USER")
 */

class FrontController extends AbstractController
{
    /**
     * @Route("/profile/{token}", name="front_profile", methods={"GET"})
     */
    public function index(AuthenticationUtils $authenticationUtils, $token): Response
    {
        $user = $this->getUser();

        if ($this->isCsrfTokenValid('profile'.$user->getId(), $token)) {
            return $this->render('front/front_index.html.twig', [
                'user' => $user,
                'last_username' => $authenticationUtils->getLastUsername(),
            ]);
        }

        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/profile/orders/{token}", name="front_profile_order_index", methods={"GET"})
     */
    public function orders(OrderRepository $orderRepository, AuthenticationUtils $authenticationUtils, $token): Response
    {
        $user = $this->getUser();
        $orders = $orderRepository->findBy(['memberId' => $user]);

        if ($this->isCsrfTokenValid('profile'.$user->getId(), $token)) {
            return $this->render('front/front_order_index.html.twig', [
                'user' => $user,
                'last_username' => $authenticationUtils->getLastUsername(),
                'orders' => $orders,
            ]);
        }

        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/profile/orders/{id}/{token}", name="front_profile_order_show", methods={"GET"})
     */
    public function show(OrderRepository $orderRepository, AuthenticationUtils $authenticationUtils, $token, $id): Response
    {
        $user = $this->getUser();
        $order = $orderRepository->find($id);

        if ($this->isCsrfTokenValid('show'.$order->getId(), $token)) {
            return $this->render('front/front_order_show.html.twig', [
                'user' => $user,
                'last_username' => $authenticationUtils->getLastUsername(),
                'order' => $order,
            ]);
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/profile/details/{token}", name="front_profile_show", methods={"GET"})
     */
    public function details(AuthenticationUtils $authenticationUtils, $token): Response
    {
        $user = $this->getUser();

        if ($this->isCsrfTokenValid('profile'.$user->getId(), $token)) {
            return $this->render('front/front_profile_show.html.twig', [
                'user' => $user,
                'last_username' => $authenticationUtils->getLastUsername(),
            ]);
        }

        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/profile/password/edit/{token}", name="front_profile_password", methods={"GET", "POST"})
     */
    public function changePassword(Request $request, AuthenticationUtils $authenticationUtils, $token, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();

        if ($this->isCsrfTokenValid('password'.$user->getId(), $token)) {

            $form = $this->createForm(ChangePasswordFormType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setUpdatedAt(new \DateTime());
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email
                $this->addFlash('success', 'Mot de passe modifié !');
                $tokenProvider = $this->container->get('security.csrf.token_manager');
                $token = $tokenProvider->getToken('profile'.$user->getId())->getValue();
                return $this->redirectToRoute('front_profile_show', [
                    'token' => $token,
                ], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('front/front_password_edit.html.twig', [
                'user' => $user,
                'form' => $form,
                'last_username' => $authenticationUtils->getLastUsername(),
                'button_label' => 'Modifier',
            ]);
        }

        return $this->redirectToRoute('home');

    }
}
