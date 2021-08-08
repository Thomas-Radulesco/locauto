<?php

namespace App\Controller;

use DateTime;
use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\MemberRepository;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * 
 * @IsGranted("ROLE_USER")
 */

class BookingController extends AbstractController
{
    /**
     * @Route("/booking/create", name="new_booking", methods={"POST"})
     */
    public function newBooking(
        Request $request,
        AuthenticationUtils $authenticationUtils,
        VehicleRepository $vehicleRepository,
        MemberRepository $memberRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = $this->getUser();
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        $booking = [];
        $booking['vehicleId'] = $vehicleRepository->findOneBy(['id' => $request->request->get('vehicleId')]);
        $booking['memberId'] = $memberRepository->findOneBy(['id' => $request->request->get('memberId')]);
        $booking['datetimeFrom'] = $request->request->get('dateFrom');
        $booking['datetimeTo'] = $request->request->get('dateTo');
        $booking['totalPrice'] = $request->request->get('totalPrice');
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $datetimeFrom = new DateTime($booking['datetimeFrom']);
            $datetimeTo = new DateTime($booking['datetimeTo']);
            $diff = date_diff($datetimeFrom, $datetimeTo);
            $diffDays = $diff->format('%a');
            $diffNumber = (int)$diffDays + 1;
            $totalPrice = $diffNumber * $booking['vehicleId']->getDailyPrice();
            $order
                ->setMemberId($booking['memberId'])
                ->setVehicleId($booking['vehicleId'])
                ->setDatetimeFrom($datetimeFrom)
                ->setDatetimeTo($datetimeTo)
                ->setTotalPrice($totalPrice)
            ;            
            $entityManager->persist($order);
            $entityManager->flush();

            $this->addFlash('success', 'Merci pour votre commande');

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order/new.html.twig', [
            'user' => $user,
            'order' => $order,
            'form' => $form,
            'last_username' => $authenticationUtils->getLastUsername(),
            'booking' => $booking,
        ]);
        
    }

}
