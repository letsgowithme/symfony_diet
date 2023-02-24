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
    
    ->setPageTitle("index", "Liste des Allergénes")
    
    ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
           
        ];
    }
    
}
