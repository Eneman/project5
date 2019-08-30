<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostRepository $repo)
    {

        $posts = $repo->findAll();
        return $this->render('home/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/post/{id}", name="view_post")
     */

    public function viewPost(Post $post)
    {

        return $this->render('home/viewPost.html.twig', [
            'post'  => $post
        ]);
    }
}
