<?php

namespace App\Controller;

use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AuthenticationUtils $authenticationUtils, VehicleRepository $vehicleRepository): Response
    {
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $vehicles = $vehicleRepository->findAll();

        return $this->render('home/index.html.twig', [
            'vehicles' => $vehicles,
            'last_username' => $lastUsername,

        ]);
    }
}
