<?php

namespace App\Controller;

use DateTime;
use App\Entity\Order;
use App\Form\OrderType;
use Doctrine\ORM\EntityManager;
use App\Repository\VehicleRepository;
use App\Entity\AvailableVehicleSearch;
use App\Form\AvailableVehicleSearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Security $security, AuthenticationUtils $authenticationUtils, VehicleRepository $vehicleRepository, Request $request): Response
    {
        $user = $this->getUser();
        $search = new AvailableVehicleSearch();
        $form = $this->createForm(AvailableVehicleSearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicles = $vehicleRepository->findAllAvailableVehicle($search);
            $dateFrom = $form->getData()->getFromDate()->format('Y-m-d H:i:s');
            $dateTo = $form->getData()->getToDate()->format('Y-m-d H:i:s');
            $disabled = null;
            $datetimeFrom = $form->getData()->getFromDate();
            $datetimeTo = $form->getData()->getToDate();
            $diff = date_diff($datetimeFrom, $datetimeTo);
            $diffDays = $diff->format('%a');
            $diffNumber = (int)$diffDays + 1;
        } else {
            $vehicles = $vehicleRepository->findAll();
            $today = new \DateTime;
            $dateFrom = $today->format('Y-m-d H:i:s');
            $dateTo = $today->format('Y-m-d H:i:s');
            $disabled = 'disabled';
            $diffNumber = 0;
        }
        $formView = $form->createView();

        return $this->render('home/index.html.twig', [
            'vehicles' => $vehicles,
            'last_username' => $authenticationUtils->getLastUsername(),
            'form' => $formView,
            'user' => $user,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'disabled' => $disabled,
            'rentalDays' => $diffNumber,
        ]);
    }
}
