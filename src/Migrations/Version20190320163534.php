<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190320163534 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE championship (id INT NOT NULL, name VARCHAR(255) NOT NULL, point_specification_win INT NOT NULL, point_specification_loose INT NOT NULL, point_specification_forfeit INT NOT NULL, point_specification_loose_with_bonus INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT NOT NULL, championship_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6DC044C594DDBCE9 (championship_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `match` (id INT AUTO_INCREMENT NOT NULL, home_team_id INT DEFAULT NULL, outside_team_id INT DEFAULT NULL, match_date DATETIME NOT NULL, score_home_team INT NOT NULL, score_outside_team INT NOT NULL, INDEX IDX_7A5BC5059C4C13F6 (home_team_id), INDEX IDX_7A5BC5055B573341 (outside_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `set` (id INT AUTO_INCREMENT NOT NULL, match_id INT DEFAULT NULL, set_number INT NOT NULL, set_point_home_team INT NOT NULL, set_point_outside_team INT NOT NULL, INDEX IDX_E61425DC2ABEACD6 (match_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C594DDBCE9 FOREIGN KEY (championship_id) REFERENCES championship (id)');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC5059C4C13F6 FOREIGN KEY (home_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC5055B573341 FOREIGN KEY (outside_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE `set` ADD CONSTRAINT FK_E61425DC2ABEACD6 FOREIGN KEY (match_id) REFERENCES `match` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C594DDBCE9');
        $this->addSql('ALTER TABLE `set` DROP FOREIGN KEY FK_E61425DC2ABEACD6');
        $this->addSql('DROP TABLE championship');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE `match`');
        $this->addSql('DROP TABLE `set`');
    }
}
