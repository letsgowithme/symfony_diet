<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class UserCrudController extends AbstractCrudController
{
public static function getEntityFqcn(): string
{
return User::class;
}

public function configureCrud(Crud $crud): Crud
{
return $crud
->setEntityLabelInPlural('Patients')
->setEntityLabelInSingular('Patient')

->setPageTitle("index", "Diet - Administration des patients")

;
}

public function configureFields(string $pageName): iterable
{
return [
IdField::new('id')
->hideOnForm(),
TextField::new('fullName'),

TextField::new('email'),
DateTimeField::new('dateOfBirth')
->hideOnForm(),
ArrayField::new('allergens'),
ArrayField::new('diets'), 
ArrayField::new('recipes'),
ArrayField::new('roles')
->hideOnIndex(),
DateTimeField::new('createdAt')
->hideOnForm()
->setFormTypeOption('disabled', 'disabled'),
];
}
}



