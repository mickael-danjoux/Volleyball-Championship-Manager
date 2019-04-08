<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190408090509 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, home_team_id INT NOT NULL, outside_team_id INT DEFAULT NULL, match_date DATETIME DEFAULT NULL, home_match TINYINT(1) DEFAULT NULL, score_home_team INT DEFAULT NULL, score_outside_team INT DEFAULT NULL, INDEX IDX_232B318C9C4C13F6 (home_team_id), INDEX IDX_232B318C5B573341 (outside_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `set` (id INT AUTO_INCREMENT NOT NULL, match_id INT DEFAULT NULL, set_number INT DEFAULT NULL, set_point_home_team INT DEFAULT NULL, set_point_outside_team INT DEFAULT NULL, INDEX IDX_E61425DC2ABEACD6 (match_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C9C4C13F6 FOREIGN KEY (home_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C5B573341 FOREIGN KEY (outside_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE `set` ADD CONSTRAINT FK_E61425DC2ABEACD6 FOREIGN KEY (match_id) REFERENCES game (id)');
        $this->addSql('DROP TABLE `match`');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `set` DROP FOREIGN KEY FK_E61425DC2ABEACD6');
        $this->addSql('CREATE TABLE `match` (id INT AUTO_INCREMENT NOT NULL, home_team_id INT NOT NULL, outside_team_id INT DEFAULT NULL, match_date DATETIME DEFAULT NULL, home_match TINYINT(1) DEFAULT NULL, score_home_team INT DEFAULT NULL, score_outside_team INT DEFAULT NULL, INDEX IDX_7A5BC5055B573341 (outside_team_id), INDEX IDX_7A5BC5059C4C13F6 (home_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC5055B573341 FOREIGN KEY (outside_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC5059C4C13F6 FOREIGN KEY (home_team_id) REFERENCES team (id)');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE `set`');
    }
}
