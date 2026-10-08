<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


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
    public function newPost(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setCreatedAt(new \DateTimeImmutable())
                 ->setUpdatedAt(new \DateTimeImmutable())
                 ->setSlug($slugger->slug($post->getTitle()));
            $manager->persist($post); // Uniquement lors d'une insertion
            $manager->flush();
            return $this->redirectToRoute('app_admin_posts');
        }
        return $this->render('admin/posts/newpost.html.twig',[
            'form' => $form]
        );
    }

    #[Route('/admin/deletepost/{id}', name: 'app_admin_posts_delete')]
    public function deletePost(Post $post, EntityManagerInterface $manager): Response
    {
        $manager->remove($post);
        $manager->flush();
        return $this->redirectToRoute('app_admin_posts');
    }

}

