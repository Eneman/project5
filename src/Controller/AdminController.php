<?php

namespace App\Controller;

use App\Form\PlayerType;
use App\Entity\User as AppUser;
use App\Repository\UserRepository;
use App\Repository\PlayerRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Player;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/admin/test", name="test")
     */
    public function test(UserRepository $repo, ObjectManager $manager)
    {
        /* $user = $this->getUser();
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); */

        $user = $repo->find(1);

        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/view/role", name="view_role")
     */
    public function viewRole(UserRepository $repo)
    {
        $users = $repo->findAll();

        return $this->render('admin/viewRole.html.twig', [
            'users' => $users
        ]);
    }
    
    /**
     * @Route("/admin/view/players", name="view_players")
     */
    public function viewPlayers(PlayerRepository $repo, ObjectManager $manager, Request $request)
    {
        $player = new Player();
        $players = $repo->findAll();

        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($player);
            $manager->flush();
            return $this->redirectToRoute('view_players');
        }

        return $this->render('admin/viewPlayers.html.twig', [
            'players' => $players,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/promote/{id}", name="admin_promote")
     */
    public function promote(AppUser $user, ObjectManager $manager)
    {
        if ($user->getRoles()[0] == "ROLE_ORGA") {
            $user->setRoles(['ROLE_ADMIN']);
        }
        elseif ($user->getRoles()[0] == "ROLE_USER") {
            $user->setRoles(['ROLE_ORGA']);
        }
        elseif ($user->getRoles()[0] == "")
        {
            $user->setRoles(['ROLE_USER']);
        }
        $manager->persist($user);
        $manager->flush();

        return $this->json(['role' => $user->getRoles()[0]], 200);
    }
    
    /**
     * @Route("/admin/demote/{id}", name="admin_demote")
     */
    public function demote(AppUser $user, ObjectManager $manager)
    {
        if ($user->getRoles()[0] == "ROLE_ADMIN") {
            $user->setRoles(['ROLE_ORGA']);
        }
        elseif ($user->getRoles()[0] == "ROLE_ORGA") {
            $user->setRoles(['ROLE_USER']);
        }
        elseif ($user->getRoles()[0] == "ROLE_USER")
        {
            $user->setRoles(['']);
        }
        $manager->persist($user);
        $manager->flush();

        return $this->json(['role' => $user->getRoles()[0]], 200);
    }
}
