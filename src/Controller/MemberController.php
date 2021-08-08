<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/profile")
 * @IsGranted("ROLE_USER")
 */
class MemberController extends AbstractController
{
    /**
     * @Route("/edit/{id}/{token}", name="front_profile_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Member $member, AuthenticationUtils $authenticationUtils, $token): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('edit'.$member->getId(), $token)) {
            $form = $this->createForm(MemberType::class, $member);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $member->setUpdatedAt(new \DateTime());

                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Compte modifié !');
                $tokenProvider = $this->container->get('security.csrf.token_manager');
                $token = $tokenProvider->getToken('profile'.$user->getId())->getValue();
                return $this->redirectToRoute('front_profile_show', [
                    'token' => $token,
                ], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('front/front_profile_edit.html.twig', [
                'user' => $user,
                'member' => $member,
                'form' => $form,
                'last_username' => $authenticationUtils->getLastUsername(),
                'button_label' => 'Mettre à jour',
            ]);
        }
    }

    /**
     * @Route("/{id}/delete/{token}", name="profile_delete", methods={"GET", "POST"})
     */
    public function delete(Member $member, $token): Response
    {
        $user=$this->getUser();

        if ($this->isCsrfTokenValid('delete'.$member->getId(), $token)) {
            $entityManager = $this->getDoctrine()->getManager();
            $ordersToRemove = $member->getOrders();
            foreach($ordersToRemove as $orderToRemove) {
                $member->removeOrder($orderToRemove);
            }
            $entityManager->remove($member);
            $entityManager->flush();

            $this->addFlash('error', 'Client supprimé !');

        }

        return $this->redirectToRoute('admin_member_index', [
            'user' => $user,
        ], Response::HTTP_SEE_OTHER);
    }
}
