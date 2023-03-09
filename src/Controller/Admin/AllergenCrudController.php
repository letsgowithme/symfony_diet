<?php

namespace App\Controller\Admin;

use App\Entity\Allergen;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AllergenCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Allergen::class;
        
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Allergène')
            ->setEntityLabelInPlural('Allergènes')
            ->setPageTitle(pageName:Crud::PAGE_INDEX, title: 'Allergènes')
            ->setPageTitle(pageName:Crud::PAGE_NEW, title: 'Créer un allergène')
            ->setPageTitle(pageName:Crud::PAGE_EDIT, title: 'Modifier allergène')
            ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('name')
            ->setLabel('Nom'),     
            IdField::new('id')
            ->hideOnForm(),       
                     
          
        ];
    }
    
}
