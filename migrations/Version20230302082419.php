<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230302082419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allergen (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_25BF08CEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, recipe_id INT NOT NULL, content LONGTEXT NOT NULL, is_approved TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9474526CF675F31B (author_id), INDEX IDX_9474526C59D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(50) NOT NULL, email VARCHAR(180) NOT NULL, subject VARCHAR(100) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diet (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_9DE46520A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, is_allergen TINYINT(1) DEFAULT NULL, INDEX IDX_6BAF7870A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mark (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, recipe_id INT NOT NULL, mark INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6674F271A76ED395 (user_id), INDEX IDX_6674F27159D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, preparation_time INT NOT NULL, pause_time INT DEFAULT NULL, cooking_time INT NOT NULL, steps LONGTEXT NOT NULL, is_public TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DA88B137A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_ingredient (recipe_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_22D1FE1359D8A214 (recipe_id), INDEX IDX_22D1FE13933FE08C (ingredient_id), PRIMARY KEY(recipe_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_allergen (recipe_id INT NOT NULL, allergen_id INT NOT NULL, INDEX IDX_532FAD5059D8A214 (recipe_id), INDEX IDX_532FAD506E775A4A (allergen_id), PRIMARY KEY(recipe_id, allergen_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_diet (recipe_id INT NOT NULL, diet_id INT NOT NULL, INDEX IDX_E2FF3FFF59D8A214 (recipe_id), INDEX IDX_E2FF3FFFE1E13ACE (diet_id), PRIMARY KEY(recipe_id, diet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, date_of_birth DATETIME NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_allergen (user_id INT NOT NULL, allergen_id INT NOT NULL, INDEX IDX_C532ECCEA76ED395 (user_id), INDEX IDX_C532ECCE6E775A4A (allergen_id), PRIMARY KEY(user_id, allergen_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_diet (user_id INT NOT NULL, diet_id INT NOT NULL, INDEX IDX_E76529E9A76ED395 (user_id), INDEX IDX_E76529E9E1E13ACE (diet_id), PRIMARY KEY(user_id, diet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_recipe (user_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_BFDAAA0AA76ED395 (user_id), INDEX IDX_BFDAAA0A59D8A214 (recipe_id), PRIMARY KEY(user_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE allergen ADD CONSTRAINT FK_25BF08CEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE diet ADD CONSTRAINT FK_9DE46520A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mark ADD CONSTRAINT FK_6674F271A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mark ADD CONSTRAINT FK_6674F27159D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE1359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE13933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_allergen ADD CONSTRAINT FK_532FAD5059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_allergen ADD CONSTRAINT FK_532FAD506E775A4A FOREIGN KEY (allergen_id) REFERENCES allergen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_diet ADD CONSTRAINT FK_E2FF3FFF59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_diet ADD CONSTRAINT FK_E2FF3FFFE1E13ACE FOREIGN KEY (diet_id) REFERENCES diet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_allergen ADD CONSTRAINT FK_C532ECCEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_allergen ADD CONSTRAINT FK_C532ECCE6E775A4A FOREIGN KEY (allergen_id) REFERENCES allergen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_diet ADD CONSTRAINT FK_E76529E9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_diet ADD CONSTRAINT FK_E76529E9E1E13ACE FOREIGN KEY (diet_id) REFERENCES diet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_recipe ADD CONSTRAINT FK_BFDAAA0AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_recipe ADD CONSTRAINT FK_BFDAAA0A59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergen DROP FOREIGN KEY FK_25BF08CEA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C59D8A214');
        $this->addSql('ALTER TABLE diet DROP FOREIGN KEY FK_9DE46520A76ED395');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870A76ED395');
        $this->addSql('ALTER TABLE mark DROP FOREIGN KEY FK_6674F271A76ED395');
        $this->addSql('ALTER TABLE mark DROP FOREIGN KEY FK_6674F27159D8A214');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137A76ED395');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE1359D8A214');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE13933FE08C');
        $this->addSql('ALTER TABLE recipe_allergen DROP FOREIGN KEY FK_532FAD5059D8A214');
        $this->addSql('ALTER TABLE recipe_allergen DROP FOREIGN KEY FK_532FAD506E775A4A');
        $this->addSql('ALTER TABLE recipe_diet DROP FOREIGN KEY FK_E2FF3FFF59D8A214');
        $this->addSql('ALTER TABLE recipe_diet DROP FOREIGN KEY FK_E2FF3FFFE1E13ACE');
        $this->addSql('ALTER TABLE user_allergen DROP FOREIGN KEY FK_C532ECCEA76ED395');
        $this->addSql('ALTER TABLE user_allergen DROP FOREIGN KEY FK_C532ECCE6E775A4A');
        $this->addSql('ALTER TABLE user_diet DROP FOREIGN KEY FK_E76529E9A76ED395');
        $this->addSql('ALTER TABLE user_diet DROP FOREIGN KEY FK_E76529E9E1E13ACE');
        $this->addSql('ALTER TABLE user_recipe DROP FOREIGN KEY FK_BFDAAA0AA76ED395');
        $this->addSql('ALTER TABLE user_recipe DROP FOREIGN KEY FK_BFDAAA0A59D8A214');
        $this->addSql('DROP TABLE allergen');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE diet');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_ingredient');
        $this->addSql('DROP TABLE recipe_allergen');
        $this->addSql('DROP TABLE recipe_diet');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_allergen');
        $this->addSql('DROP TABLE user_diet');
        $this->addSql('DROP TABLE user_recipe');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
