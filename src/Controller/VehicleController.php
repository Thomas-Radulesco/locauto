<?php

namespace App\Controller;

use DateTime;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use App\Service\ImageUploaderHelper;
use ContainerA5ZDMgU\getVehicleService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("admin/vehicles")
 * @IsGranted("ROLE_ADMIN")
 */
class VehicleController extends AbstractController
{
    /**
     * @Route("/", name="admin_vehicle_index", methods={"GET","POST"})
     */
    public function index(VehicleRepository $vehicleRepository, Request $request, AuthenticationUtils $authenticationUtils, ImageUploaderHelper $imageUploaderHelper): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle, ['attr' => ['class' => 'container']]);
        $formView = $form->createView();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                /** @var PictureFile $pictureFile */
                $pictureFile = $form->get('pictureFile')->getData();
                if ($pictureFile) {
                    $filename = uniqid() . '.' . $pictureFile->guessExtension();

                    $pictureFile->move(
                        $this->getParameter('cars_pictures_directory'),
                        $filename
                    );

                    $vehicle->setPicture($filename);
                }
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($vehicle);
                $entityManager->flush();

                $this->addFlash('success', 'Véhicule ajouté !');

                return $this->redirectToRoute('admin_vehicle_index', [], Response::HTTP_SEE_OTHER);
            } else {

                $this->addFlash('error', 'Le formulaire n\'est pas correctement rempli');

            }

        }

        return $this->render('admin/admin_vehicle_index.html.twig', [
            'vehicles' => $vehicleRepository->findAll(),
            'vehicle' => $vehicle,
            'form' => $formView,
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_vehicle_show", methods={"GET"})
     */
    public function show(Vehicle $vehicle, AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('admin/admin_vehicle_show.html.twig', [
            'vehicle' => $vehicle,
            'last_username' => $authenticationUtils->getLastUsername()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_vehicle_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vehicle $vehicle, AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PictureFile $pictureFile */
            $pictureFile = $form->get('pictureFile')->getData();
            if ($pictureFile) {
                $filename = uniqid() . '.' . $pictureFile->guessExtension();

                $pictureFile->move(
                    $this->getParameter('cars_pictures_directory'),
                    $filename
                );

                if($vehicle->getPicture()) {
                    unlink($this->getParameter('cars_pictures_directory').'/'.$vehicle->getPicture());
                }
                
                $vehicle->setPicture($filename);
            }
            $vehicle->setUpdatedAt(new DateTime());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Véhicule modifié !');

        }

        return $this->renderForm('admin/admin_vehicle_edit.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form,
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    /**
     * @Route("/{id}/delete/{token}", name="admin_vehicle_delete", methods={"GET", "POST"})
     */
    public function delete(Vehicle $vehicle, $token): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicle->getId(), $token)) {
            $entityManager = $this->getDoctrine()->getManager();
            $ordersToRemove = $vehicle->getOrders();
            foreach($ordersToRemove as $orderToRemove) {
                $vehicle->removeOrder($orderToRemove);
            }
            if($vehicle->getPicture()) {
                unlink($this->getParameter('cars_pictures_directory').'/'.$vehicle->getPicture());
            }
            $entityManager->remove($vehicle);
            $entityManager->flush();

            $this->addFlash('error', 'Véhicule supprimé !');
        }

        return $this->redirectToRoute('admin_vehicle_index', [], Response::HTTP_SEE_OTHER);
    }
}
