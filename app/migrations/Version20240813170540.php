<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240813170540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tasks ADD first_interval_type VARCHAR(30) DEFAULT NULL, ADD second_interval_type VARCHAR(30) DEFAULT NULL, DROP third_note, DROP fourth_note');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tasks ADD third_note VARCHAR(3) DEFAULT NULL, ADD fourth_note VARCHAR(3) DEFAULT NULL, DROP first_interval_type, DROP second_interval_type');
    }
}
