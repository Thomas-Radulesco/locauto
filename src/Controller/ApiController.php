<?php

namespace App\Controller;

use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
     /**
     * @Route("/photos/vehicle/{id}", name="api_photo_vehicle_show", methods={"GET"})
     */
    public function showPhoto($id, VehicleRepository $vehicleRepository):JsonResponse
    {
        $vehicle = $vehicleRepository->find($id);
        
        return $this->json([
            'vehicleName' => $vehicle->getTitle(),
            'vehiclePicture' => $vehicle->getPicture()
        ]);
    }
}
