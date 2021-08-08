<?php

namespace App\Admin\Controller;

use App\Entity\Member;
use App\Form\MemberType;
use App\Form\MemberAdminType;
use App\Repository\MemberRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin/members")
 * @IsGranted("ROLE_ADMIN")
 */
class MemberController extends AbstractController
{
    /**
     * @Route("/", name="admin_member_index", methods={"GET"})
     */
    public function index(MemberRepository $memberRepository, AuthenticationUtils $authenticationUtils): Response
    {
        $user=$this->getUser();

        return $this->render('admin/admin_member_index.html.twig', [
            'user' => $user,
            'members' => $memberRepository->findAll(),
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_member_show", methods={"GET"})
     */
    public function show(Member $member, AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();

        return $this->render('admin/admin_member_show.html.twig', [
            'user' => $user,
            'member' => $member,
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_member_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Member $member, AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(MemberAdminType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $member->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Client modifié !');

            return $this->redirectToRoute('admin_member_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_member_edit.html.twig', [
            'user' => $user,
            'member' => $member,
            'form' => $form,
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    /**
     * @Route("/{id}/delete/{token}", name="admin_member_delete", methods={"GET", "POST"})
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
