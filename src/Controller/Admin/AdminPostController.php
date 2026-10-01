<?php

namespace App\Controller\Admin;

use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class AdminPostController extends AbstractController
{
    #[Route('/admin/posts', name: 'app_admin_posts')]
    public function posts(PostRepository $repository): Response
    {
        $posts = $repository->findBy(
            [],
            ['createdAt' => 'DESC']
        );
        return $this->render('admin/posts/posts.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/admin/newpost', name: 'app_admin_newpost')]
    public function newPost(): Response
    {
        $form = $this->createForm(PostType::class);
        return $this->render('admin/posts/newpost.html.twig',[
            'form' => $form]
        );
    }

}

