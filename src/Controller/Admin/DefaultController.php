<?php

namespace App\Controller\Admin;

use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin', name: 'app_admin_default.')]
#[IsGranted('ROLE_USER')]
class DefaultController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(RecipeRepository $repository, EntityManagerInterface $em): Response
    {
        $em->flush();
        $recipes = $repository->findAll();
        return $this->render('admin/recipe/index.html.twig', ['recipes' => $recipes]);
    }
}