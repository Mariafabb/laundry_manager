<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623092014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordini ADD CONSTRAINT FK_F720A0ADDE734E51 FOREIGN KEY (cliente_id) REFERENCES clienti (id)');
        $this->addSql('ALTER TABLE ordini ADD CONSTRAINT FK_F720A0ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F720A0ADDE734E51 ON ordini (cliente_id)');
        $this->addSql('CREATE INDEX IDX_F720A0ADA76ED395 ON ordini (user_id)');
        $this->addSql('ALTER TABLE ordini_row DROP FOREIGN KEY FK_197F30847523C16');
        $this->addSql('ALTER TABLE ordini_row DROP FOREIGN KEY FK_197F3084F7C04F72');
        $this->addSql('DROP INDEX IDX_197F30847523C16 ON ordini_row');
        $this->addSql('DROP INDEX IDX_197F3084F7C04F72 ON ordini_row');
        $this->addSql('ALTER TABLE ordini_row ADD capo_id INT NOT NULL, ADD ordine_id INT NOT NULL, DROP capo_id_id, DROP ordine_id_id');
        $this->addSql('ALTER TABLE ordini_row ADD CONSTRAINT FK_197F3084E70D4E41 FOREIGN KEY (capo_id) REFERENCES capi (id)');
        $this->addSql('ALTER TABLE ordini_row ADD CONSTRAINT FK_197F3084685E286D FOREIGN KEY (ordine_id) REFERENCES ordini (id)');
        $this->addSql('CREATE INDEX IDX_197F3084E70D4E41 ON ordini_row (capo_id)');
        $this->addSql('CREATE INDEX IDX_197F3084685E286D ON ordini_row (ordine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordini DROP FOREIGN KEY FK_F720A0ADDE734E51');
        $this->addSql('ALTER TABLE ordini DROP FOREIGN KEY FK_F720A0ADA76ED395');
        $this->addSql('DROP INDEX IDX_F720A0ADDE734E51 ON ordini');
        $this->addSql('DROP INDEX IDX_F720A0ADA76ED395 ON ordini');
        $this->addSql('ALTER TABLE ordini_row DROP FOREIGN KEY FK_197F3084E70D4E41');
        $this->addSql('ALTER TABLE ordini_row DROP FOREIGN KEY FK_197F3084685E286D');
        $this->addSql('DROP INDEX IDX_197F3084E70D4E41 ON ordini_row');
        $this->addSql('DROP INDEX IDX_197F3084685E286D ON ordini_row');
        $this->addSql('ALTER TABLE ordini_row ADD capo_id_id INT NOT NULL, ADD ordine_id_id INT NOT NULL, DROP capo_id, DROP ordine_id');
        $this->addSql('ALTER TABLE ordini_row ADD CONSTRAINT FK_197F30847523C16 FOREIGN KEY (capo_id_id) REFERENCES capi (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE ordini_row ADD CONSTRAINT FK_197F3084F7C04F72 FOREIGN KEY (ordine_id_id) REFERENCES ordini (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_197F30847523C16 ON ordini_row (capo_id_id)');
        $this->addSql('CREATE INDEX IDX_197F3084F7C04F72 ON ordini_row (ordine_id_id)');
    }
}
