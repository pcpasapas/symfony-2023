<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226095024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier ADD alimentation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF28441D4D9 FOREIGN KEY (alimentation_id) REFERENCES alimentation (id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF28441D4D9 ON panier (alimentation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE processeur CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE carte_mere CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF28441D4D9');
        $this->addSql('DROP INDEX IDX_24CC0DF28441D4D9 ON panier');
        $this->addSql('ALTER TABLE panier DROP alimentation_id');
        $this->addSql('ALTER TABLE ram CHANGE category_id category_id INT DEFAULT NULL');
    }
}
