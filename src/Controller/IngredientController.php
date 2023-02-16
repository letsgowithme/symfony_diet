<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class IngredientController extends AbstractController
{
  /**
   * This function display all ingredients
   *
   * @param IngredientRepository $repository
   * @return Response
   */
  #[Route('/ingredient', name: 'ingredient.index', methods: ['GET'])]
  public function index(IngredientRepository $repository): Response
  {
    $ingredients = $repository->findAll();
    return $this->render('pages/ingredient/index.html.twig', [
      'ingredients' => $ingredients
    ]);
  }

  /**
   * This function create an ingredients
   * @param Request $request
   * @param EntityManagerInterface $manager
   * @return Response
   */
  #[Route('/ingredient/nouveau', 'ingredient.new', methods: ['GET', 'POST'])]
  public function new(
    Request $request,
    EntityManagerInterface $manager

  ): Response {
    $ingredient = new Ingredient();
    $form = $this->createForm(IngredientType::class, $ingredient);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $ingredient = $form->getData();

      $manager->persist($ingredient);
      $manager->flush();

      $this->addFlash(
        'success',
        'Votre ingrédient a bien été créé'
      );

      return $this->redirectToRoute('ingredient.index');
    }
    return $this->render('pages/ingredient/new.html.twig', [
      'form' => $form->createView()
    ]);
  }
  /**
   * This function edits the ingredient
   * @param Request $request
   * @param Ingredient $ingredient
   * @return Response
   */

  #[Route('ingredient/edition/{id}', 'ingredient.edit', methods: ['GET', 'POST'])]
  public function edit(

    Ingredient $ingredient,
    EntityManagerInterface $manager,
    Request $request
  ): Response {

    $form = $this->createForm(IngredientType::class, $ingredient);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
    }
    ($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $ingredient = $form->getData();

      $manager->persist($ingredient);
      $manager->flush();

      $this->addFlash(
        'success',
        'Votre ingrédient a été modifié avec succès !'
      );

      return $this->redirectToRoute('ingredient.index');
    }

    return $this->render('pages/ingredient/edit.html.twig', [
      'form' => $form->createView()
    ]);
  }

  /**
   * This controller allows us to delete an ingredient
   *
   * @param EntityManagerInterface $manager
   * @param Ingredient $ingredient
   * @return Response
   */
  #[Route('/ingredient/suppression/{id}', 'ingredient.delete', methods: ['GET'])]

  public function delete(
    EntityManagerInterface $manager,
    Ingredient $ingredient
  ): Response {
    $manager->remove($ingredient);
    $manager->flush();

    $this->addFlash(
      'success',
      'Votre ingrédient a été supprimé avec succès !'
    );

    return $this->redirectToRoute('ingredient.index');
  }
}
