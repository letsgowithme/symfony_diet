<?php

namespace App\Form;

use App\Entity\Allergen;
use App\Entity\Diet;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Repository\AllergenRepository;
use App\Repository\DietRepository;
use App\Repository\IngredientRepository;
// use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RecipeType extends AbstractType
{
    // private $token;

    // public function __construct(TokenStorageInterface $token)
    // {
            
    //         $this->token = $token;
    // }
   

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Nom',
            'label_attr' => [
                'class' => 'form-label mt-4 text-dark fs-5',
                'minLength' => '2',
                'maxLength' => '50'
            ],
            'constraints' => [
                new Assert\Length(['min' => 2, 'max' => 50]),
                new Assert\NotBlank()
            ]
        ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-4 text-dark fs-5'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('preparationTime', IntegerType::class, [
                'attr' => [
                'class' => 'form-control',
                'min' => 1,
                'max' => 1440
                ],
                'label' => 'Temps de préparation en minutes',
                'label_attr' => [
                    'class' => 'form-label mt-4 text-dark fs-5'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(1440)
                ]
            ])
            ->add('pauseTime', IntegerType::class, [
                'attr' => [
                'class' => 'form-control',
                'min' => 0,
                'max' => 1440
                ],
                'label' => 'Temps de repos en minutes',
                'label_attr' => [
                    'class' => 'form-label mt-4 text-dark fs-5'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(1440)
                ]
            ])
            ->add('cookingTime', IntegerType::class, [
                'attr' => [
                'class' => 'form-control',
                'min' => 0,
                'max' => 1440
                ],
                'label' => 'Temps de cuisson en minutes',
                'label_attr' => [
                    'class' => 'form-label mt-4 text-dark fs-5'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(1440)
                ]
            ])

            ->add('ingredients', EntityType::class,[
                'class' => Ingredient::class,
                'query_builder' => function (IngredientRepository $r) {
                    return $r->createQueryBuilder('i')
                        // ->where('i.user = :user')
                        ->orderBy('i.name', 'ASC')
                        // ->setParameter('user', $this->token->getToken()->getUser());
               ;
                    },
                'label' => 'Ingrédients',
                'label_attr' => [
                    'class' => 'form-label mt-4 text-dark fs-5'
                ],
                
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
                

            ])

            ->add('steps', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Étapes',
                'label_attr' => [
                    'class' => 'form-label mt-4 text-dark fs-5'
                
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
              ->add('allergens', EntityType::class,[
                'class' => Allergen::class,
                'query_builder' => function (AllergenRepository $r) {
                    return $r->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
                },
                'label' => 'Allergènes',
                'label_attr' => [
                    'class' => 'form-label mt-4 text-dark fs-5'
                ],
                
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            
            ->add('diets', EntityType::class,[
                'class' => Diet::class,
                'query_builder' => function (DietRepository $r) {
                    return $r->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
                },
                'label' => 'Régimes',
                'label_attr' => [
                    'class' => 'form-label mt-4 text-dark fs-5'
                ],
                
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('isBase', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input mt-4',
                ],
                'required' => false,
                'label' => 'Recette de base ? ',
                'label_attr' => [
                    'class' => 'form-check-label mt-4 text-dark fs-5'
                ],
                'constraints' => [
                    new Assert\NotNull()
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4 mb-4 text-dark fs-5'
                ],
            'label' => 'Sauvegarder la recette'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
