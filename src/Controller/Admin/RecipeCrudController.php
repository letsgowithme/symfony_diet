<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }
    public function configureCrud(Crud $crud): Crud
{
  return $crud
      ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
}

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id')
            // ->hideOnForm(),
            TextField::new('name')
                    ->setLabel('Nom'),
                    
            ImageField::new('imageName')
                        ->setFormType(FileUploadType::class)
                        ->setUploadDir('/public/images/recipe')
                        ->setRequired(false)
                        ->setLabel('Image'),
            TextEditorField::new('description')
            ->setFormType(CKEditorType::class)
            ->hideOnIndex(),
            NumberField::new('preparationTime')
                        ->setLabel('Temps de préparation (en minutes)')
                        ->hideOnIndex(),
                        
            NumberField::new('pauseTime')
            ->setLabel('Temps de pause (en minutes)')
            ->hideOnIndex(),
            NumberField::new('cookingTime')
            ->setLabel('Temps de cuisson (en minutes)')
            ->hideOnIndex(),
            AssociationField::new('ingredients')
            ->setLabel('Ingrédients')
            ->hideOnIndex(),
            TextEditorField::new('steps')
            ->setFormType(CKEditorType::class)
            ->setLabel('Étapes')
            ->hideOnIndex(),
            AssociationField::new('allergens')
            ->setLabel('Allergènes'),
            AssociationField::new('diets')
            ->setLabel('Régimes'),
            // AssociationField::new('users')
            // ->setLabel('Users'),
            BooleanField::new('isPublic')
            ->setLabel('Recette publque ?')
            ];
            }
            }