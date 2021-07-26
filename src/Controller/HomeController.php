<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use Doctrine\ORM\EntityManager;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AuthenticationUtils $authenticationUtils, VehicleRepository $vehicleRepository, Request $request): Response
    {
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $vehicles = $vehicleRepository->findAll();

        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $formView = $form->createView();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/index.html.twig', [
            'vehicles' => $vehicles,
            'last_username' => $lastUsername,
            'form' =>$formView,
        ]);
    }
}
