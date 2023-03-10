<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(
        RecipeRepository $recipeRepository
    ): Response
    {
        return $this->render('pages/home/index.html.twig', [
            'recipes' => $recipeRepository->findPublicRecipe(3)
        ]);
    }
   
    #[Route('/legal_notice', name: 'footer.legal_notice', methods: ['GET'])]
    public function legalNotice(
        RecipeRepository $recipeRepository
    ): Response
    {
        return $this->render('pages/footer/legal_notice.html.twig');
    }
    #[Route('/privacy', name: 'footer.privacy_policy', methods: ['GET'])]
    public function privacy(
        RecipeRepository $recipeRepository
    ): Response
    {
        return $this->render('pages/footer/privacy_policy.html.twig');
    }
}
