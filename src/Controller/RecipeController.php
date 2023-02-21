<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Entity\Recipe;
use App\Form\MarkType;
use App\Form\RecipeType;
use App\Repository\MarkRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Show the recipes if user is connected
  * @param RecipeRepository $repository
   * @return Response
 */
class RecipeController extends AbstractController
{
    #[Route('/recette', name: 'recipe.index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(RecipeRepository $repository): Response
    {
        $recipes = $repository->findBy(['user' => $this->getUser()]);
        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

/**
 * Show the recipes publique for all
   * @param RecipeRepository $repository
   * @return Response 
 */
    #[Route('recette/publique', 'recipe.index_public', methods: ['GET'])]
    public function indexPublic(RecipeRepository $repository): Response
    {
        $recipes = $repository->findPublicRecipe(100);
        return $this->render('pages/recipe/index_public.html.twig', [
            'recipes' => $recipes
        ]);
    }


  

    /*********************************************************************** */
    /**
     * This function creates a recipe
     * @param Recipe $recipe
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/recette/creation', 'recipe.new', methods: ['GET', 'POST'])]
   
    public function new(
        Request $request,
        EntityManagerInterface $manager,
        

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
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response

     */



     #[Route('recette/edition/{id}', 'recipe.edit', methods: ['GET', 'POST'])]
     #[IsGranted('ROLE_USER')]
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
      #[Security("is_granted('ROLE_USER') and user === recipe.getUser()")]
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
       /**
     * Show the recipes of a user
  * @param Recipe $recipe
  * @param Request $request
  * @param EntityManagerInterface $manager
   * @return Response
 */
#[Security("is_granted('ROLE_USER') and (recipe.getIsPublic() === true || user === recipe.getUser())")]
#[Route('recette/{id}', 'recipe.show', methods: ['GET', 'POST'])]
    public function show(
        Recipe $recipe, 
        Request $request, 
        MarkRepository $markRepository,
        EntityManagerInterface $manager
        ): Response 
        {
            
        $mark = new Mark();
        $form = $this->createForm(MarkType::class, $mark);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
               $mark->setUser($this->getUser())
                          ->setRecipe($recipe);

            $existingMark = $markRepository->findOneBy([
                'user' => $this->getUser(),
                'recipe' => $recipe
            ]);
            if(!$existingMark) {
                $manager->persist($mark);
            }else {
                $existingMark->setmark(
                    $form->getData()->getMark()
                );
            }
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre note a bien été prise en compte'
            );
            return $this->redirectToRoute('recipe.show', ['id' => $recipe->getId()]);
            }

            return $this->render('pages/recipe/show.html.twig', [
                'recipe' => $recipe,
                'form' => $form->createView()
            ]);
    }
 
 
 
 }
