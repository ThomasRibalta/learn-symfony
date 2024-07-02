<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    #[Route('/recipes', name: 'recipe.index')]
    public function index(Request $request, RecipeRepository $repository): Response
    {
        $recipes = $repository->findAll();
        return $this->render('recipe/index.html.twig', ['recipes' => $recipes]);
    }

    #[Route('/recipes/{slug}-{id}', name: 'recipe.show', requirements: ['id' => '\d+', 'slug' => '[a-zA-Z0-9-]+'])]
    public function show(RecipeRepository $repository, int $id, string $slug): Response
    {
        $recipe = $repository->find($id);
        if (!$recipe || $recipe->getSlug() !== $slug)
        {
            return $this->redirectToRoute('recipe.index', [], 301);
        }
        return $this->render('recipe/show.html.twig', ['recipe' => $recipe]);
    }

    #[Route('/recipes/{id}/edit', name: 'recipe.edit', requirements: ['id' => '\d+'])]
    public function edit(Recipe $recipe, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            $this->addFlash('success', 'Recipe updated successfully');
            return $this->redirectToRoute('recipe.show', ['id' => $recipe->getId(), 'slug' => $recipe->getSlug()]);
        }
        return $this->render('recipe/edit.html.twig', ['recipe' => $recipe, 'form' => $form->createView()]);
    }

    #[Route('/recipes/create', name: 'recipe.create')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success', 'Recipe created successfully');
            return $this->redirectToRoute('recipe.index');
        }
        return $this->render('recipe/create.html.twig', ['form' => $form]);
    }

    #[Route('/recipes/{id}/delete', name: 'recipe.delete', requirements: ['id' => '\d+'])]
    public function delete(Recipe $recipe, EntityManagerInterface $em): Response
    {
        $em->remove($recipe);
        $em->flush();
        $this->addFlash('success', 'Recipe deleted successfully');
        return $this->redirectToRoute('recipe.index');
    }
}
