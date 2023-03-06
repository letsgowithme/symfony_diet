<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230306184502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137A76ED395');
        $this->addSql('DROP INDEX IDX_DA88B137A76ED395 ON recipe');
        $this->addSql('ALTER TABLE recipe DROP user_id');
        $this->addSql('ALTER TABLE user ADD recipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64959D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64959D8A214 ON user (recipe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DA88B137A76ED395 ON recipe (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64959D8A214');
        $this->addSql('DROP INDEX IDX_8D93D64959D8A214 ON user');
        $this->addSql('ALTER TABLE user DROP recipe_id');
    }
}
