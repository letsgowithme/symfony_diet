<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
  * @param RecipeRepository $repository
   * @return Response
 */
class RecipeController extends AbstractController
{
    #[Route('/admin/recette', name: 'recipe.index', methods: ['GET'])]
    public function index(RecipeRepository $repository): Response
    {
        $recipes = $repository->findBy(['user' => $this->getUser()]);
        // $recipes = $repository->findAll();
        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    /*********************************************************************** */
    /**
     * This function creates a recipe
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/recette/nouveau', 'recipe.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager

    ) : Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $recipe->setUser($this->getUser());

            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre recette a bien été créé'
            );

            return $this->redirectToRoute('recipe.index');
        }
return $this->render('pages/recipe/new.html.twig', [
    'form' => $form->createView()
]);
    }
 /**
     * This function edits the recipe
     * @param Recipe $recipe
     * @return Response
     */



     #[Route('recette/edition/{id}', 'recipe.edit', methods: ['GET', 'POST'])]
     public function edit(
 
         Recipe $recipe,
         EntityManagerInterface $manager,
         Request $request
     ) : Response {
 
         $form = $this->createForm(RecipeType::class, $recipe);
         $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
             $recipe = $form->getData();
 
             $manager->persist($recipe);
             $manager->flush();
 
             $this->addFlash(
                 'success',
                 'Votre recette a été modifié avec succès !'
             );
 
             return $this->redirectToRoute('recipe.index');
         }
 
 
         return $this->render('pages/recipe/edit.html.twig', [
             'form' => $form->createView()
         ]);
     }
     /**
      * This controller allows us to delete a recipe
      *
      * @param EntityManagerInterface $manager
      * @param Recipe $recipe
      * @return Response
      */
     #[Route('/recette/suppression/{id}', 'recipe.delete', methods: ['GET'])]
 
     public function delete(
         EntityManagerInterface $manager,
         Recipe $recipe
     ): Response {
        
         $manager->remove($recipe);
         $manager->flush();
 
         $this->addFlash(
             'success',
             'Votre recette a été supprimé avec succès !'
         );
 
         return $this->redirectToRoute('recipe.index');
     }
 
 
 
 }
