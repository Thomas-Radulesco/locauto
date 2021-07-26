<?php

namespace App\Admin\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('admin/admin_index.html.twig', [
            'controller_name' => 'AdminController',
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }
}
