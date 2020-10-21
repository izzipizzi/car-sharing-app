<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201020061009 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cars (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, model VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, year INT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, client_id_id INT NOT NULL, car_id_id INT NOT NULL, tariff_id_id INT NOT NULL, location VARCHAR(255) NOT NULL, date_from DATE NOT NULL, price INT NOT NULL, time TIME NOT NULL, UNIQUE INDEX UNIQ_E52FFDEEDC2902E0 (client_id_id), UNIQUE INDEX UNIQ_E52FFDEEA0EF1B80 (car_id_id), UNIQUE INDEX UNIQ_E52FFDEE75E354CD (tariff_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, theme VARCHAR(255) NOT NULL, text VARCHAR(255) NOT NULL, INDEX IDX_6970EB0FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tariff (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(30) NOT NULL, surname VARCHAR(30) NOT NULL, phone VARCHAR(15) NOT NULL, city VARCHAR(20) NOT NULL, street VARCHAR(50) NOT NULL, house INT DEFAULT NULL, flat INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEDC2902E0 FOREIGN KEY (client_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA0EF1B80 FOREIGN KEY (car_id_id) REFERENCES cars (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE75E354CD FOREIGN KEY (tariff_id_id) REFERENCES tariff (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA0EF1B80');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE75E354CD');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEDC2902E0');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FA76ED395');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE cars');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE tariff');
        $this->addSql('DROP TABLE user');
    }
}
