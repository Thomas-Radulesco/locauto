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
        $user = $this->getUser();

        return $this->render('admin/admin_index.html.twig', [
            'user' => $user,
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }
}
