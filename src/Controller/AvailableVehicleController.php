<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvailableVehicleController extends AbstractController
{
    /**
     * @Route("/available/vehicle", name="available_vehicle")
     */
    public function index(): Response
    {
        return $this->render('available_vehicle/index.html.twig', [
            'controller_name' => 'AvailableVehicleController',
        ]);
    }
}
