<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
->setSearchFields(['fullName'])
->setPageTitle("index", "Diet - Administration des patients")
->setDefaultSort(['fullName' => 'asc'])
;
}



public function configureFields(string $pageName): iterable
{
    // $roles = ['ROLE_ADMIN', 'ROLE_USER'];
return [
IdField::new('id')
->hideOnForm(),
TextField::new('fullName')
->setLabel('Nom/Prénom'),
TextField::new('email'),
TextField::new('plainPassword', 'password')
    ->setFormType(PasswordType::class)
    ->setRequired($pageName === Crud::PAGE_NEW)
    ->onlyOnForms()
    ->setLabel('Mot de passe'),
DateTimeField::new('dateOfBirth')
->hideOnForm()
->setLabel('Date de naissance'),
AssociationField::new('allergens')
->setLabel('Allergènes'),
AssociationField::new('diets')
->setLabel('Régimes'), 
AssociationField::new('recipes')
->setLabel('Recettes'),
// ArrayField::new('roles')
//         ->setLabel('Rôle'),
DateTimeField::new('createdAt')
->hideOnForm()
->setFormTypeOption('disabled', 'disabled'),
];
}
public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
{
    $this->encodePassword($entityInstance);
    parent::persistEntity($entityManager, $entityInstance);
}

public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
{
    $this->encodePassword($entityInstance);
    parent::updateEntity($entityManager, $entityInstance);
}
private UserPasswordHasherInterface $hasher;

public function __construct(UserPasswordHasherInterface $hasher) 
{
$this->hasher = $hasher;
}
public function prePersist(User $user) {
$this->encodePassword($user);
}

public function preUpdate(User $user) {
$this->encodePassword($user);
}
/**
* 
* Encode password based on plain password
*
* @param User $user
* @return void
*/
private function encodePassword(User $user)
{
    if ($user->getPlainPassword() !== null) {
        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $user->getPlainPassword()
   
   )
   );
   $user->setPlainPassword(null);
   }

    }
}




