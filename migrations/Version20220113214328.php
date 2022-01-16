<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220113214328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE omniva (id INT AUTO_INCREMENT NOT NULL, zip_code INT NOT NULL, name VARCHAR(255) NOT NULL, type INT NOT NULL, a0_name VARCHAR(255) DEFAULT NULL, a1_name VARCHAR(255) DEFAULT NULL, a2_name VARCHAR(255) DEFAULT NULL, a3_name VARCHAR(255) DEFAULT NULL, a4_name VARCHAR(255) DEFAULT NULL, a5_name VARCHAR(255) DEFAULT NULL, a6_name VARCHAR(255) DEFAULT NULL, a7_name VARCHAR(255) DEFAULT NULL, a8_name VARCHAR(255) DEFAULT NULL, x_coordinate VARCHAR(15) NOT NULL, y_coordinate VARCHAR(15) NOT NULL, service_hours VARCHAR(255) DEFAULT NULL, temp_service_hours VARCHAR(255) DEFAULT NULL, temp_service_hours_until VARCHAR(255) DEFAULT NULL, temp_service_hours2 VARCHAR(255) DEFAULT NULL, temp_service_hours2_until VARCHAR(255) DEFAULT NULL, comment_est VARCHAR(255) DEFAULT NULL, comment_eng VARCHAR(255) DEFAULT NULL, comment_rus VARCHAR(255) DEFAULT NULL, comment_lav VARCHAR(255) DEFAULT NULL, comment_lit VARCHAR(255) DEFAULT NULL, modified DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE omniva');
    }
}
