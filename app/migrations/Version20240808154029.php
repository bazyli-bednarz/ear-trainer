<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240808154029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE node ADD course_id INT DEFAULT NULL, ADD previous_node_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE node ADD CONSTRAINT FK_857FE845591CC992 FOREIGN KEY (course_id) REFERENCES courses (id)');
        $this->addSql('ALTER TABLE node ADD CONSTRAINT FK_857FE8457796F504 FOREIGN KEY (previous_node_id) REFERENCES node (id)');
        $this->addSql('CREATE INDEX IDX_857FE845591CC992 ON node (course_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_857FE8457796F504 ON node (previous_node_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE node DROP FOREIGN KEY FK_857FE845591CC992');
        $this->addSql('ALTER TABLE node DROP FOREIGN KEY FK_857FE8457796F504');
        $this->addSql('DROP INDEX IDX_857FE845591CC992 ON node');
        $this->addSql('DROP INDEX UNIQ_857FE8457796F504 ON node');
        $this->addSql('ALTER TABLE node DROP course_id, DROP previous_node_id');
    }
}
