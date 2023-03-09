<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class IngredientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ingredient::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
    return $crud
                ->setEntityLabelInPlural('Ingrédient')
                ->setEntityLabelInSingular('Ingrédients')
                ->setSearchFields(['name'])
                ->setPageTitle("index", "Ingrédients")
                ->setDefaultSort(['name' => 'asc'])
                ->setPageTitle(pageName:Crud::PAGE_INDEX, title: 'Ingrédients')
                ->setPageTitle(pageName:Crud::PAGE_NEW, title: 'Créer un ingrédient')
                ->setPageTitle(pageName:Crud::PAGE_EDIT, title: 'Modifier l\'ingrédient')
    ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('name')
            ->setLabel('Nom'),
            BooleanField::new('isAllergen')
            ->setLabel('Allergène ?')
            
        ];
    }
    
}
