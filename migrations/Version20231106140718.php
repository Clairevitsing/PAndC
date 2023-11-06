<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231106140718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nft (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, launch_date DATETIME NOT NULL, launch_price_eur DOUBLE PRECISION NOT NULL, launch_price_eth DOUBLE PRECISION NOT NULL, INDEX IDX_D9C7463C8A1465B4 (nft:read), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nft_price (id INT AUTO_INCREMENT NOT NULL, nft_id INT NOT NULL, price_date DATETIME NOT NULL, eth_value DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_8D397C7AE813668D (nft_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_nft (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nft_id INT NOT NULL, purchase_date DATETIME NOT NULL, nft_price_eth DOUBLE PRECISION NOT NULL, nft_price_eur DOUBLE PRECISION NOT NULL, INDEX IDX_FBAA39E813668D (nft_id), INDEX IDX_FBAA39A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, gender VARCHAR(255) DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, profil_picture VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463C8A1465B4 FOREIGN KEY (nft:read) REFERENCES category (id)');
        $this->addSql('ALTER TABLE nft_price ADD CONSTRAINT FK_8D397C7AE813668D FOREIGN KEY (nft_id) REFERENCES nft (id)');
        $this->addSql('ALTER TABLE purchase_nft ADD CONSTRAINT FK_FBAA39E813668D FOREIGN KEY (nft_id) REFERENCES nft (id)');
        $this->addSql('ALTER TABLE purchase_nft ADD CONSTRAINT FK_FBAA39A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463C8A1465B4');
        $this->addSql('ALTER TABLE nft_price DROP FOREIGN KEY FK_8D397C7AE813668D');
        $this->addSql('ALTER TABLE purchase_nft DROP FOREIGN KEY FK_FBAA39E813668D');
        $this->addSql('ALTER TABLE purchase_nft DROP FOREIGN KEY FK_FBAA39A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F5B7AF75');
        $this->addSql('DROP TABLE nft');
        $this->addSql('DROP TABLE nft_price');
        $this->addSql('DROP TABLE purchase_nft');
        $this->addSql('DROP TABLE user');
    }
}
