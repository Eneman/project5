<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\User;

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
    public function viewRole(UserRepository $repo, ObjectManager $manager)
    {
        $users = $repo->findAll();

        return $this->render('admin/viewRole.html.twig', [
            'users' => $users
        ]);

    }
}
