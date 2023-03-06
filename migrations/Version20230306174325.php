<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230306174325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_allergen DROP FOREIGN KEY FK_C532ECCEA76ED395');
        $this->addSql('ALTER TABLE user_allergen DROP FOREIGN KEY FK_C532ECCE6E775A4A');
        $this->addSql('ALTER TABLE user_diet DROP FOREIGN KEY FK_E76529E9E1E13ACE');
        $this->addSql('ALTER TABLE user_diet DROP FOREIGN KEY FK_E76529E9A76ED395');
        $this->addSql('ALTER TABLE user_recipe DROP FOREIGN KEY FK_BFDAAA0AA76ED395');
        $this->addSql('ALTER TABLE user_recipe DROP FOREIGN KEY FK_BFDAAA0A59D8A214');
        $this->addSql('DROP TABLE user_allergen');
        $this->addSql('DROP TABLE user_diet');
        $this->addSql('DROP TABLE user_recipe');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_allergen (user_id INT NOT NULL, allergen_id INT NOT NULL, INDEX IDX_C532ECCEA76ED395 (user_id), INDEX IDX_C532ECCE6E775A4A (allergen_id), PRIMARY KEY(user_id, allergen_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_diet (user_id INT NOT NULL, diet_id INT NOT NULL, INDEX IDX_E76529E9A76ED395 (user_id), INDEX IDX_E76529E9E1E13ACE (diet_id), PRIMARY KEY(user_id, diet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_recipe (user_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_BFDAAA0AA76ED395 (user_id), INDEX IDX_BFDAAA0A59D8A214 (recipe_id), PRIMARY KEY(user_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_allergen ADD CONSTRAINT FK_C532ECCEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_allergen ADD CONSTRAINT FK_C532ECCE6E775A4A FOREIGN KEY (allergen_id) REFERENCES allergen (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_diet ADD CONSTRAINT FK_E76529E9E1E13ACE FOREIGN KEY (diet_id) REFERENCES diet (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_diet ADD CONSTRAINT FK_E76529E9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_recipe ADD CONSTRAINT FK_BFDAAA0AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_recipe ADD CONSTRAINT FK_BFDAAA0A59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
