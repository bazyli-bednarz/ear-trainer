<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240811143747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nodes (id INT AUTO_INCREMENT NOT NULL, course_id INT DEFAULT NULL, previous_node_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) NOT NULL, INDEX IDX_1D3D05FC591CC992 (course_id), UNIQUE INDEX UNIQ_1D3D05FC7796F504 (previous_node_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nodes ADD CONSTRAINT FK_1D3D05FC591CC992 FOREIGN KEY (course_id) REFERENCES courses (id)');
        $this->addSql('ALTER TABLE nodes ADD CONSTRAINT FK_1D3D05FC7796F504 FOREIGN KEY (previous_node_id) REFERENCES nodes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nodes DROP FOREIGN KEY FK_1D3D05FC591CC992');
        $this->addSql('ALTER TABLE nodes DROP FOREIGN KEY FK_1D3D05FC7796F504');
        $this->addSql('DROP TABLE nodes');
    }
}
