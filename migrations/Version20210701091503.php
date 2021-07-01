<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701091503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capi (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(255) NOT NULL, sottotipo VARCHAR(255) DEFAULT NULL, descrizione VARCHAR(255) DEFAULT NULL, prezzo DOUBLE PRECISION NOT NULL, giorni_lavorazione INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clienti (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, cognome VARCHAR(255) NOT NULL, indirizzo VARCHAR(255) DEFAULT NULL, comune VARCHAR(255) DEFAULT NULL, provincia VARCHAR(255) DEFAULT NULL, stato VARCHAR(255) DEFAULT NULL, cap INT DEFAULT NULL, telefono VARCHAR(255) DEFAULT NULL, cellulare VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, codice_fiscale VARCHAR(255) DEFAULT NULL, p_iva VARCHAR(255) DEFAULT NULL, codice_univoco VARCHAR(255) DEFAULT NULL, pec VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE impostazioni (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, valore VARCHAR(255) NOT NULL, descrizione VARCHAR(255) DEFAULT NULL, tipo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordini (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, user_id INT NOT NULL, note LONGTEXT DEFAULT NULL, data_ordine DATE NOT NULL, data_consegna DATE DEFAULT NULL, totale DOUBLE PRECISION NOT NULL, INDEX IDX_F720A0ADDE734E51 (cliente_id), INDEX IDX_F720A0ADA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordini_row (id INT AUTO_INCREMENT NOT NULL, capo_id INT NOT NULL, ordine_id INT NOT NULL, importo DOUBLE PRECISION NOT NULL, data_consegna DATE DEFAULT NULL, INDEX IDX_197F3084E70D4E41 (capo_id), INDEX IDX_197F3084685E286D (ordine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nome VARCHAR(255) DEFAULT NULL, cognome VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ordini ADD CONSTRAINT FK_F720A0ADDE734E51 FOREIGN KEY (cliente_id) REFERENCES clienti (id)');
        $this->addSql('ALTER TABLE ordini ADD CONSTRAINT FK_F720A0ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ordini_row ADD CONSTRAINT FK_197F3084E70D4E41 FOREIGN KEY (capo_id) REFERENCES capi (id)');
        $this->addSql('ALTER TABLE ordini_row ADD CONSTRAINT FK_197F3084685E286D FOREIGN KEY (ordine_id) REFERENCES ordini (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordini_row DROP FOREIGN KEY FK_197F3084E70D4E41');
        $this->addSql('ALTER TABLE ordini DROP FOREIGN KEY FK_F720A0ADDE734E51');
        $this->addSql('ALTER TABLE ordini_row DROP FOREIGN KEY FK_197F3084685E286D');
        $this->addSql('ALTER TABLE ordini DROP FOREIGN KEY FK_F720A0ADA76ED395');
        $this->addSql('DROP TABLE capi');
        $this->addSql('DROP TABLE clienti');
        $this->addSql('DROP TABLE impostazioni');
        $this->addSql('DROP TABLE ordini');
        $this->addSql('DROP TABLE ordini_row');
        $this->addSql('DROP TABLE user');
    }
}
