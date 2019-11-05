<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Slide;
use App\Entity\Trame;
use App\Entity\Player;
use App\Form\PostType;
use App\Entity\GNEvent;
use App\Form\PlayerType;
use App\Form\SliderType;
use App\Entity\User as AppUser;
use App\Repository\PostRepository;
use App\Repository\SlideRepository;
use App\Repository\UserRepository;
use App\Repository\TrameRepository;
use App\Repository\PlayerRepository;
use App\Repository\GNEventRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     * @Route("/admin/create/post", name="new_post")
     */
    public function createPost(Request $request, ObjectManager $manager)
    {
        $post = new Post();
        $post->setDate(new \DateTime());
        $form = $this->createForm(PostType::class, $post,);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute('view_post', ["id" => $post->getId()]);
        }

        return $this->render('admin/editPost.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'new' => true
        ]);
    }

    /**
     * @Route("/admin/posts", name="view_posts")
     */
    public function viewPosts(PostRepository $repo)
    {

        $posts = $repo->findAll();
        return $this->render('admin/viewPosts.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("admin/post/{id}/edit", name="edit_post")
     */
    public function editPost(Post $post = null, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(PostType::class, $post,);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute('view_post', ["id" => $post->getId()]);
        }

        return $this->render('admin/editPost.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'new' => false
        ]);
    }

    /**
     * @Route("admin/post/delete/{id}", name="delete_post")
     */

    public function deletePost(Post $post, ObjectManager $manager)
    {
        $manager->remove($post);
        $manager->flush();
        
        return $this->redirectToRoute('view_posts');
    }

    /**
     * @Route("admin/unlock/event/{id}", name="unlock_event")
     */
    public function unlockEvent(GNEvent $gnEvent, ObjectManager $manager)
    {
        $gnEvent->setLocked("");
        $manager->flush();
        return $this->redirectToRoute('orga');
    }

    /**
     * @Route("admin/unlock/trame/{id}", name="unlock_trame")
     */
    public function unlockTrame(Trame $trame, ObjectManager $manager)
    {
        $trame->setLocked("");
        $manager->flush();
        return $this->redirectToRoute('view_event', ["id" => $trame->getGnevent()->getId()]);
    }

    /**
     * @Route("admin/slide/new", name="new_slide")
     */
    public function newSlide(Request $request, ObjectManager $manager)
    {
        $slide = new Slide();
        $slide->setUpdatedAt(new \DateTime());
        $form = $this->createForm(SliderType::class, $slide);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($slide);
            $manager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('admin/newSlide.html.twig', [
            'slide' => $slide,
            'form' => $form->createView(),
            'new' => true
        ]);
    }
}
