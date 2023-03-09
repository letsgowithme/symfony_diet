<?php

namespace App\Controller\Admin;

use App\Entity\Diet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DietCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Diet::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Régime')
            ->setEntityLabelInPlural('Régimes')
            ->setPageTitle(pageName:Crud::PAGE_INDEX, title: 'Régimes')
            ->setPageTitle(pageName:Crud::PAGE_NEW, title: 'Créer le régime')
            ->setPageTitle(pageName:Crud::PAGE_EDIT, title: 'Modifier le régime')
            
            ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('name')
            ->setLabel('Nom'),
            
        ];
    }
    
}
