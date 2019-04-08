<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190408084356 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE championship (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, began TINYINT(1) NOT NULL, specification_point_win_point INT NOT NULL, specification_point_loose_point INT NOT NULL, specification_point_forfeit_point INT NOT NULL, specification_point_loose_with_bonus_point INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE championship_team (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, pool_id INT DEFAULT NULL, championship_id INT NOT NULL, point INT NOT NULL, INDEX IDX_E0E69356296CD8AE (team_id), INDEX IDX_E0E693567B3406DF (pool_id), INDEX IDX_E0E6935694DDBCE9 (championship_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, manager_first_name VARCHAR(255) NOT NULL, manager_last_name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cup (id INT NOT NULL, name VARCHAR(255) NOT NULL, playoff INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `match` (id INT AUTO_INCREMENT NOT NULL, home_team_id INT DEFAULT NULL, outside_team_id INT DEFAULT NULL, match_date DATETIME NOT NULL, home_match TINYINT(1) DEFAULT NULL, score_home_team INT NOT NULL, score_outside_team INT NOT NULL, INDEX IDX_7A5BC5059C4C13F6 (home_team_id), INDEX IDX_7A5BC5055B573341 (outside_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pool (id INT AUTO_INCREMENT NOT NULL, championship_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_AF91A98694DDBCE9 (championship_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `set` (id INT AUTO_INCREMENT NOT NULL, match_id INT DEFAULT NULL, set_number INT NOT NULL, set_point_home_team INT NOT NULL, set_point_outside_team INT NOT NULL, INDEX IDX_E61425DC2ABEACD6 (match_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, club_id INT DEFAULT NULL, validate TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, manager_first_name VARCHAR(255) NOT NULL, manager_last_name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_C4E0A61F61190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_slot (id INT AUTO_INCREMENT NOT NULL, volleyball_court_id INT DEFAULT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, INDEX IDX_1B3294A42C67BB (volleyball_court_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE volleyball_court (id INT AUTO_INCREMENT NOT NULL, club_id INT DEFAULT NULL, place VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, INDEX IDX_7C099BD661190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE volleyball_court_day (volleyball_court_id INT NOT NULL, day_id INT NOT NULL, INDEX IDX_D2C3076042C67BB (volleyball_court_id), INDEX IDX_D2C307609C24126 (day_id), PRIMARY KEY(volleyball_court_id, day_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE championship_team ADD CONSTRAINT FK_E0E69356296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE championship_team ADD CONSTRAINT FK_E0E693567B3406DF FOREIGN KEY (pool_id) REFERENCES pool (id)');
        $this->addSql('ALTER TABLE championship_team ADD CONSTRAINT FK_E0E6935694DDBCE9 FOREIGN KEY (championship_id) REFERENCES championship (id)');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC5059C4C13F6 FOREIGN KEY (home_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC5055B573341 FOREIGN KEY (outside_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE pool ADD CONSTRAINT FK_AF91A98694DDBCE9 FOREIGN KEY (championship_id) REFERENCES championship (id)');
        $this->addSql('ALTER TABLE `set` ADD CONSTRAINT FK_E61425DC2ABEACD6 FOREIGN KEY (match_id) REFERENCES `match` (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F61190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE time_slot ADD CONSTRAINT FK_1B3294A42C67BB FOREIGN KEY (volleyball_court_id) REFERENCES volleyball_court (id)');
        $this->addSql('ALTER TABLE volleyball_court ADD CONSTRAINT FK_7C099BD661190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE volleyball_court_day ADD CONSTRAINT FK_D2C3076042C67BB FOREIGN KEY (volleyball_court_id) REFERENCES volleyball_court (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE volleyball_court_day ADD CONSTRAINT FK_D2C307609C24126 FOREIGN KEY (day_id) REFERENCES day (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE championship_team DROP FOREIGN KEY FK_E0E6935694DDBCE9');
        $this->addSql('ALTER TABLE pool DROP FOREIGN KEY FK_AF91A98694DDBCE9');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F61190A32');
        $this->addSql('ALTER TABLE volleyball_court DROP FOREIGN KEY FK_7C099BD661190A32');
        $this->addSql('ALTER TABLE volleyball_court_day DROP FOREIGN KEY FK_D2C307609C24126');
        $this->addSql('ALTER TABLE `set` DROP FOREIGN KEY FK_E61425DC2ABEACD6');
        $this->addSql('ALTER TABLE championship_team DROP FOREIGN KEY FK_E0E693567B3406DF');
        $this->addSql('ALTER TABLE championship_team DROP FOREIGN KEY FK_E0E69356296CD8AE');
        $this->addSql('ALTER TABLE `match` DROP FOREIGN KEY FK_7A5BC5059C4C13F6');
        $this->addSql('ALTER TABLE `match` DROP FOREIGN KEY FK_7A5BC5055B573341');
        $this->addSql('ALTER TABLE time_slot DROP FOREIGN KEY FK_1B3294A42C67BB');
        $this->addSql('ALTER TABLE volleyball_court_day DROP FOREIGN KEY FK_D2C3076042C67BB');
        $this->addSql('DROP TABLE championship');
        $this->addSql('DROP TABLE championship_team');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE cup');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE `match`');
        $this->addSql('DROP TABLE pool');
        $this->addSql('DROP TABLE `set`');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE time_slot');
        $this->addSql('DROP TABLE volleyball_court');
        $this->addSql('DROP TABLE volleyball_court_day');
    }
}
