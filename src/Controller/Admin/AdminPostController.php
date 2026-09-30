<?php

namespace App\Controller\Admin;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class AdminPostController extends AbstractController
{
    #[Route('/admin/posts', name: 'app_admin_posts')]
    public function index(): Response
    {
        return $this->render('admin/posts/posts.html.twig');
    }
}

