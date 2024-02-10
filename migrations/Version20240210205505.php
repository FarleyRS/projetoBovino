<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240210205505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cow (id INT AUTO_INCREMENT NOT NULL, fazenda_id INT DEFAULT NULL, codigo INT NOT NULL, qt_leite DOUBLE PRECISION NOT NULL, qt_racao DOUBLE PRECISION NOT NULL, peso DOUBLE PRECISION NOT NULL, nascimento DATE NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_99D43F9CD4A3545F (fazenda_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE farm (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(50) NOT NULL, tamanho DOUBLE PRECISION NOT NULL, responsavel VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_5816D04554BD530C (nome), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE farm_veterinarian (farm_id INT NOT NULL, veterinarian_id INT NOT NULL, INDEX IDX_499A5CC65FCFA0D (farm_id), INDEX IDX_499A5CC804C8213 (veterinarian_id), PRIMARY KEY(farm_id, veterinarian_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinarian (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(50) NOT NULL, crmv VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_4E5C18053697FA2C (crmv), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cow ADD CONSTRAINT FK_99D43F9CD4A3545F FOREIGN KEY (fazenda_id) REFERENCES farm (id)');
        $this->addSql('ALTER TABLE farm_veterinarian ADD CONSTRAINT FK_499A5CC65FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE farm_veterinarian ADD CONSTRAINT FK_499A5CC804C8213 FOREIGN KEY (veterinarian_id) REFERENCES veterinarian (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cow DROP FOREIGN KEY FK_99D43F9CD4A3545F');
        $this->addSql('ALTER TABLE farm_veterinarian DROP FOREIGN KEY FK_499A5CC65FCFA0D');
        $this->addSql('ALTER TABLE farm_veterinarian DROP FOREIGN KEY FK_499A5CC804C8213');
        $this->addSql('DROP TABLE cow');
        $this->addSql('DROP TABLE farm');
        $this->addSql('DROP TABLE farm_veterinarian');
        $this->addSql('DROP TABLE veterinarian');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
