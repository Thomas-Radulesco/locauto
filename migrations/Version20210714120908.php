<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210714120908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(20) NOT NULL, password VARCHAR(60) NOT NULL, last_name VARCHAR(20) NOT NULL, first_name VARCHAR(20) NOT NULL, email_address VARCHAR(50) NOT NULL, gender ENUM(\'Femme\', \'Homme\', \'Non spécifié\') NOT NULL COMMENT \'(DC2Type:enumgender)\', roles JSON DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, member_id_id INT NOT NULL, vehicle_id_id INT NOT NULL, datetime_from DATETIME NOT NULL, datetime_to DATETIME NOT NULL, total_price INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F52993981D650BA4 (member_id_id), INDEX IDX_F52993981DEB1EBB (vehicle_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(200) NOT NULL, brand VARCHAR(50) DEFAULT NULL, model VARCHAR(50) DEFAULT NULL, description LONGTEXT DEFAULT NULL, picture VARCHAR(200) DEFAULT NULL, daily_price INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993981D650BA4 FOREIGN KEY (member_id_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993981DEB1EBB FOREIGN KEY (vehicle_id_id) REFERENCES vehicle (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993981D650BA4');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993981DEB1EBB');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE vehicle');
    }
}
