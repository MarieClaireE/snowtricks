<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220805124758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD email LONGTEXT NOT NULL, ADD password VARCHAR(20) NOT NULL, ADD token_new_password VARCHAR(255) NOT NULL, ADD date_new_password DATE NOT NULL, ADD expire_token_new_password DATE NOT NULL, ADD token_new_user VARCHAR(255) NOT NULL, ADD date_token_new_user VARCHAR(255) NOT NULL, DROP description, DROP type, DROP slug, CHANGE name name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD type INT NOT NULL, ADD slug LONGTEXT NOT NULL, DROP password, DROP token_new_password, DROP date_new_password, DROP expire_token_new_password, DROP token_new_user, DROP date_token_new_user, CHANGE name name LONGTEXT NOT NULL, CHANGE email description LONGTEXT NOT NULL');
    }
}
