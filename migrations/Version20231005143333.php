<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231005143333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft_collection ADD nft_id INT NOT NULL');
        $this->addSql('ALTER TABLE nft_collection ADD CONSTRAINT FK_EB2638C0E813668D FOREIGN KEY (nft_id) REFERENCES nft (id)');
        $this->addSql('CREATE INDEX IDX_EB2638C0E813668D ON nft_collection (nft_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft_collection DROP FOREIGN KEY FK_EB2638C0E813668D');
        $this->addSql('DROP INDEX IDX_EB2638C0E813668D ON nft_collection');
        $this->addSql('ALTER TABLE nft_collection DROP nft_id');
    }
}
