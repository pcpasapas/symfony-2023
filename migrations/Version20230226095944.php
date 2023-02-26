<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226095944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier ADD carte_graphique_id INT DEFAULT NULL, ADD ram_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF221E1B659 FOREIGN KEY (carte_graphique_id) REFERENCES carte_graphique (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF23366068 FOREIGN KEY (ram_id) REFERENCES ram (id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF221E1B659 ON panier (carte_graphique_id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF23366068 ON panier (ram_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte_mere CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processeur CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ram CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF221E1B659');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF23366068');
        $this->addSql('DROP INDEX IDX_24CC0DF221E1B659 ON panier');
        $this->addSql('DROP INDEX IDX_24CC0DF23366068 ON panier');
        $this->addSql('ALTER TABLE panier DROP carte_graphique_id, DROP ram_id');
    }
}