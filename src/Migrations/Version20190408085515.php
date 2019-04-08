<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190408085515 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `match` CHANGE score_home_team score_home_team INT DEFAULT NULL, CHANGE score_outside_team score_outside_team INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `set` CHANGE set_number set_number INT DEFAULT NULL, CHANGE set_point_home_team set_point_home_team INT DEFAULT NULL, CHANGE set_point_outside_team set_point_outside_team INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `match` CHANGE score_home_team score_home_team INT NOT NULL, CHANGE score_outside_team score_outside_team INT NOT NULL');
        $this->addSql('ALTER TABLE `set` CHANGE set_number set_number INT NOT NULL, CHANGE set_point_home_team set_point_home_team INT NOT NULL, CHANGE set_point_outside_team set_point_outside_team INT NOT NULL');
    }
}
