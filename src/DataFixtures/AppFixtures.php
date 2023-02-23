<?php

namespace App\DataFixtures;

use App\Entity\Allergen;
use App\Entity\Contact;
use App\Entity\Diet;
use App\Entity\Ingredient;
use App\Entity\Mark;
use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;




class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;


    public function  __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
         // Users
         $users = [];
         for ($j = 0; $j < 10; $j++) {
            $user = new User();
            $user->setFullName($this->faker->name())
                ->setEmail($this->faker->email())
                // ->setDateOfBirth(new \DateTime('22-06-2000'))
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');
             
                $users[] = $user;
            $manager->persist($user);
        }
        
        //Ingredients
        $ingredients = [];
        for ($i = 0; $i < 25; $i++) {
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word())
                       ->setIsAllergen(mt_rand(0, 1) == 1 ? true : false);
            $ingredient->setUser($users[mt_rand(0, count($users) - 1)]);
            $ingredients[] = $ingredient;
            $manager->persist($ingredient);
        }
        //Allergens
        $allergens = [];
        for ($n = 0; $n < 20; $n++) {
            $allergen = new Allergen();
            $allergen->setName($this->faker->word());
            $allergen->setUser($users[mt_rand(0, count($users) - 1)]);
            $allergens[] = $allergen;
            $manager->persist($allergen);
        }

        //Diets
        $diets = [];
        for ($n = 0; $n < 20; $n++) {
            $diet = new Diet();
            $diet->setName($this->faker->word());
            $diet->setUser($users[mt_rand(0, count($users) - 1)]);
            $diets[] = $diet;
            $manager->persist($diet);
        }

        //Recipes
        $recipes = [];
        for ($j = 0; $j < 25; $j++) {
            $recipe = new Recipe();
            $recipe->setName($this->faker->word())
                ->setDescription($this->faker->text(100))
                ->setPreparationTime(mt_rand(1, 1440))
                ->setPauseTime(mt_rand(1, 1440))
                ->setCookingTime(mt_rand(1, 1440));

            for ($k = 0; $k < mt_rand(5, 15); $k++) {
                $recipe->addIngredient($ingredients[mt_rand(0, count($ingredients) - 1)]);
            }
            $recipe->setSteps($this->faker->text(100));

            for ($b = 0; $b < mt_rand(0, 5); $b++) {
                $recipe->addAllergen($allergens[mt_rand(0, count($allergens) - 1)]);
            }
            for ($g = 0; $g < mt_rand(0, 5); $g++) {
                $recipe->addDiet($diets[mt_rand(0, count($diets) - 1)]);
            }
            $recipe->setisPublic(mt_rand(0, 1) == 1 ? true : false);
            
            $recipe->setUser($users[mt_rand(0, count($users) - 1)]);
           

            $recipes[] = $recipe;
            $manager->persist($recipe);
        }
         // Marks
         foreach ($recipes as $recipe) {
            for ($i = 0; $i < mt_rand(0, 4); $i++) {
                $mark = new Mark();
                $mark->setMark(mt_rand(1, 5))
                    ->setUser($users[mt_rand(0, count($users) - 1)])
                    ->setRecipe($recipe);

                $manager->persist($mark);
            }
        }
             // Contact
             for ($j = 0; $j < 5; $j++) {
            $contact = new Contact();
            $contact->setFullName($this->faker->name())
                ->setEmail($this->faker->email())
                ->setSubject($this->faker->words(3))
                ->setMessage($this->faker->text());

            $manager->persist($contact);
        }

        

        $manager->flush();
    }
}

