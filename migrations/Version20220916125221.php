<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916125221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires ADD parent_id INT DEFAULT NULL, ADD active TINYINT(1) NOT NULL, ADD rgpd TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4727ACA70 FOREIGN KEY (parent_id) REFERENCES commentaires (id)');
        $this->addSql('CREATE INDEX IDX_D9BEC0C4727ACA70 ON commentaires (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4727ACA70');
        $this->addSql('DROP INDEX IDX_D9BEC0C4727ACA70 ON commentaires');
        $this->addSql('ALTER TABLE commentaires DROP parent_id, DROP active, DROP rgpd');
    }
}
