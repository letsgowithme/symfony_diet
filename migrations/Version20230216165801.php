<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230216165801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diet ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE diet ADD CONSTRAINT FK_9DE46520A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9DE46520A76ED395 ON diet (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diet DROP FOREIGN KEY FK_9DE46520A76ED395');
        $this->addSql('DROP INDEX IDX_9DE46520A76ED395 ON diet');
        $this->addSql('ALTER TABLE diet DROP user_id');
    }
}
