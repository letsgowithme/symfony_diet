<?php

namespace App\Tests\Unit;

use App\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RecipeTest extends KernelTestCase
{
    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $recipe = new Recipe();
        $recipe->setName('Recipe #1')
               ->setDescription('Recipe #1 description')
            //    ->setCreatedAt(new \DateTimeImmutable())
               ->setUpdatedAt(new \DateTimeImmutable());

        $errors = $container->get('validator')->validate($recipe);

        $this->assertCount(0, $errors);
       
    }
}
