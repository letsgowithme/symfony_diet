<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;

class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('name'),
            ImageField::new('imageName')
                        ->setFormType(FileUploadType::class)
                        ->setUploadDir('/public/images/recipe')
                        ->setRequired(false),
            TextEditorField::new('description'),
            NumberField::new('preparationTime'),
            NumberField::new('pauseTime'),
            NumberField::new('cookingTime'),
            AssociationField::new('ingredients'),
            TextEditorField::new('steps'),
            AssociationField::new('allergens'),
            AssociationField::new('diets')
            ];
            }
            }