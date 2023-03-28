<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Entity\Recipe;
use App\Entity\User;
use App\Form\RecipeType;
use App\Form\CommentType;
use App\Form\MarkType;
use App\Repository\MarkRepository;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Route('/recipe')]
class RecipeController extends AbstractController
{/**
     * Show the recipes if user is connected
     * @param RecipeRepository $recipeRepository
     * @return Response
     */
    #[Route('/', name: 'recipe.index', methods: ['GET'])]
     #[IsGranted('ROLE_USER')]
    public function index(RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll();
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }
  
    /**
     * Show all the recipes for admin
     * @param RecipeRepository $recipeRepository
     * @return Response
     */

     #[IsGranted('ROLE_ADMIN')]
     #[Route('/all_recipes', name: 'recipe.recipes', methods: ['GET'])]
     public function allRecipes(RecipeRepository $recipeRepository): Response
     {
         $recipes = $recipeRepository->findAll();
         return $this->render('recipe/recipes.html.twig', [
             'recipes' => $recipes,
         ]);
     }
 
 
     /**
      * Show the public recipes for all
      * @param RecipeRepository $recipeRepository
      * @return Response 
      */
 
     #[Route('/public', 'recipe.index_public', methods: ['GET'])]
     public function indexPublic(RecipeRepository $recipeRepository): Response
     {
         $recipes = $recipeRepository->findPublicRecipe(100);
         return $this->render('recipe/index_public.html.twig', [
             'recipes' => $recipes
         ]);
     }

 /**
     * This function creates a recipe
     * @param Recipe $recipe
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

     #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'recipe.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager, $id): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $recipe->setUser($this->getUser());
            $recipe->setUser($id);
            $manager->persist($recipe);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre recette a bien été créé'
            );
            return $this->redirectToRoute('recipe.index');
        }

        return $this->render('recipe/new.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    /**
     * Show the recipe detail of a user
     * @param Recipe $recipe
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

     #[IsGranted('ROLE_USER')]
     #[Route('/show/{id}', 'recipe.show', methods: ['GET', 'POST'])]
     public function show(
         Recipe $recipe,
         Request $request,
         MarkRepository $markRepository,
         EntityManagerInterface $manager
     ): Response {
 
         $comment = new \App\Entity\Comment();
         if ($this->getUser()) {
             $comment->setAuthor($this->getUser());
         }
         $mark = new Mark();
 
 
         $formComment = $this->createForm(CommentType::class, $comment);
         $formMark = $this->createForm(MarkType::class, $mark);
 
         $formComment->handleRequest($request);
         $formMark->handleRequest($request);
 
         /* form comments */
 
         if ($formComment->isSubmitted() && $formComment->isValid()) {
             $comment->setAuthor($this->getUser())
                     ->setRecipe($recipe);
             $manager->persist($comment);
             $manager->flush();
             $this->addFlash(
                 'success',
                 'Votre commentaire a bien été prise en compte'
             );
             return $this->redirectToRoute('recipe.show', ['id' => $recipe->getId()]);
         }
 
         /* form marks   */
         if ($formMark->isSubmitted() && $formMark->isValid()) {
             $mark->setUser($this->getUser())
                 ->setRecipe($recipe);
             $manager->persist($mark);
 
             $existingMark = $markRepository->findOneBy([
                 'user' => $this->getUser(),
                 'recipe' => $recipe
             ]);
             if (!$existingMark) {
                 $manager->persist($mark);
             } else {
                 $existingMark->setmark(
                     $formMark->getData()->getMark()
                 );
             }
 
 
             $manager->flush();
             $this->addFlash(
                 'success',
                 'Votre note a bien été prise en compte'
             );
             return $this->redirectToRoute('recipe.show', [
                 'id' => $recipe->getId()
             ]);
         }
 
         return $this->render('recipe/show.html.twig', [
             'recipe' => $recipe,
             'formMark' => $formMark->createView(),
             'formComment' => $formComment->createView()
 
         ]);
     }
     /**
      * Show a public recipe
      * @param Recipe $recipe
      * @param Request $request
      * @param EntityManagerInterface $manager
      * @return Response
      */
 
     #[Route('/public/show/{id}', 'recipe.show_public', methods: ['GET', 'POST'])]
     public function show_public(
         Recipe $recipe,
         Request $request,
         MarkRepository $markRepository,
         EntityManagerInterface $manager,
         RecipeRepository $recipeRepository
     ): Response {
        $recipes = $recipeRepository->findPublicRecipe(100);
         $comment = new \App\Entity\Comment();
         if ($this->getUser()) {
             $comment->setAuthor($this->getUser());
         }
         $mark = new Mark();
 
 
         $formComment = $this->createForm(CommentType::class, $comment);
         $formMark = $this->createForm(MarkType::class, $mark);
 
         $formComment->handleRequest($request);
         $formMark->handleRequest($request);
 
         /* form comments */
 
         if ($formComment->isSubmitted() && $formComment->isValid()) {
             $comment->setAuthor($this->getUser())
                 ->setRecipe($recipe);
             $manager->persist($comment);
             $manager->flush();
             $this->addFlash(
                 'success',
                 'Votre commentaire a bien été prise en compte'
             );
             return $this->redirectToRoute('recipe.show_public', ['id' => $recipe->getId()]);
         }
 
         /* form marks   */
         if ($formMark->isSubmitted() && $formMark->isValid()) {
             $mark->setUser($this->getUser())
                 ->setRecipe($recipe);
             $manager->persist($mark);
 
             $existingMark = $markRepository->findOneBy([
                 'user' => $this->getUser(),
                 'recipe' => $recipe
             ]);
             if (!$existingMark) {
                 $manager->persist($mark);
             } else {
                 $existingMark->setmark(
                     $formMark->getData()->getMark()
                 );
             }
 
 
             $manager->flush();
             $this->addFlash(
                 'success',
                 'Votre note a bien été prise en compte'
             );
             return $this->redirectToRoute('recipe.show', [
                 'id' => $recipe->getId()
             ]);
         }
 
         return $this->render('recipe/show_public.html.twig', [
             'recipe' => $recipe,
             'formMark' => $formMark->createView(),
             'formComment' => $formComment->createView()
 
         ]);
     }

   /**
     * This function edits the recipe
     * @param Recipe $recipe
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response

     */
    #[Route('/{id}/edit/', 'recipe.edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(

        Recipe $recipe,
        EntityManagerInterface $manager,
        Request $request
    ): Response {

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

            return $this->redirectToRoute('recipe.recipes');
        }


        return $this->render('recipe/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * This function edits the recipe
     * @param Recipe $recipe
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response

     */
    #[Route('/public/{id}/edit/', 'recipe.edit_public', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function editPublic(

        Recipe $recipe,
        EntityManagerInterface $manager,
        Request $request
    ): Response {

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

            return $this->redirectToRoute('recipe.recipes');
        }


        return $this->render('recipe/edit_public.html.twig', [
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
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/delete/', 'recipe.delete', methods: ['GET'])]

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
    

        return $this->redirectToRoute('recipe.recipes');
    }
}
