<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190131012035 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, id_brand_id INT NOT NULL, motorisation VARCHAR(255) NOT NULL, fuel VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, transmission VARCHAR(255) NOT NULL, driven VARCHAR(255) NOT NULL, INDEX IDX_773DE69D142E3C9D (id_brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favory (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_F232B2A879F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_27BA704B79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, id_cart_id INT NOT NULL, id_history_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, image_url VARCHAR(255) NOT NULL, INDEX IDX_1F1B251EC44864CF (id_cart_id), INDEX IDX_1F1B251EBB8F0485 (id_history_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, id_favory_id INT DEFAULT NULL, id_history_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code INT NOT NULL, country VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D6492F3BE887 (id_favory_id), UNIQUE INDEX UNIQ_8D93D649BB8F0485 (id_history_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D142E3C9D FOREIGN KEY (id_brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE favory ADD CONSTRAINT FK_F232B2A879F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704B79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EC44864CF FOREIGN KEY (id_cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EBB8F0485 FOREIGN KEY (id_history_id) REFERENCES history (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492F3BE887 FOREIGN KEY (id_favory_id) REFERENCES favory (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BB8F0485 FOREIGN KEY (id_history_id) REFERENCES history (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D142E3C9D');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EC44864CF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492F3BE887');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EBB8F0485');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BB8F0485');
        $this->addSql('ALTER TABLE favory DROP FOREIGN KEY FK_F232B2A879F37AE5');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704B79F37AE5');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE favory');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE user');
    }
}
