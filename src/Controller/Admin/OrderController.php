<?php

namespace App\Admin\Controller;

use DateTime;
use App\Entity\Order;
use App\Form\OrderType;
use App\Form\OrderAdminType;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("admin/orders")
 * @IsGranted("ROLE_ADMIN")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="admin_order_index", methods={"GET"})
     */
    public function index(OrderRepository $orderRepository, AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();

        return $this->render('admin/admin_order_index.html.twig', [
            'user' => $user,
            'orders' => $orderRepository->findAll(),
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_order_show", methods={"GET"})
     */
    public function show(Order $order, AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();
     
        return $this->render('admin/admin_order_show.html.twig', [
            'user' => $user,
            'order' => $order,
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Order $order, AuthenticationUtils $authenticationUtils, $id): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(OrderAdminType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Commande modifiée !');

            return $this->redirectToRoute('admin_order_edit', [
                'id' => $id,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_order_edit.html.twig', [
            'user' => $user,
            'order' => $order,
            'form' => $form,
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    /**
     * @Route("/{id}/delete/{token}", name="admin_order_delete", methods={"GET", "POST"})
     */
    public function delete(Order $order, $token): Response
    {
        $user = $this->getUser();

        if ($this->isCsrfTokenValid('delete'.$order->getId(), $token)) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();

            $this->addFlash('error', 'Commande supprimée !');

        }

        return $this->redirectToRoute('admin_order_index', [
            'user' => $user,
        ], Response::HTTP_SEE_OTHER);
    }
}
