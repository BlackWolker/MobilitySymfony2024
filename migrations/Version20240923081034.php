<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923081034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT IDENTITY NOT NULL, libelle NVARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE produit (id INT IDENTITY NOT NULL, une_categorie_id INT NOT NULL, designation NVARCHAR(100) NOT NULL, detail NVARCHAR(255), prix NUMERIC(6, 2) NOT NULL, photo NVARCHAR(100) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_29A5EC2776D5A8E ON produit (une_categorie_id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2776D5A8E FOREIGN KEY (une_categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
       
        $this->addSql('ALTER TABLE produit DROP CONSTRAINT FK_29A5EC2776D5A8E');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE produit');
    }
}
