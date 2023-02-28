<?php

namespace App\Controller\Admin;

use App\Entity\Allergen;
use App\Entity\Contact;
use App\Entity\Diet;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Entity\User;
use App\Repository\RecipeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
    #[IsGranted('ROLE_ADMIN')]
 #[Route('/all_recipes', name: 'recipe.recipes', methods: ['GET'])]
 public function allRecipes(RecipeRepository $recipeRepository): Response
 {
    return $this->render('recipe/recipes.html.twig');
    
 }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Diet - Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('Collection', 'fas fa-list', 'recipe.recipes');
        yield MenuItem::linkToCrud('Patients', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Demandes de contact', 'fas fa-envelope', Contact::class);
        yield MenuItem::linkToCrud('Ingrédients', 'fas fa-carrot', Ingredient::class);
        yield MenuItem::linkToCrud('Allergènes', 'fas fa-hand-dots', Allergen::class);
        yield MenuItem::linkToCrud('Recettes', 'fas fa-bowl-food', Recipe::class);
        yield MenuItem::linkToCrud('Régimes', 'fas fa-seedling', Diet::class);
    }
   
}

