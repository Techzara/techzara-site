<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181017083300 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tz_cms_translation DROP FOREIGN KEY FK_4BABC32B2C2AC5D3');
        $this->addSql('DROP TABLE tz_cms');
        $this->addSql('DROP TABLE tz_cms_translation');
        $this->addSql('DROP TABLE tz_devis');
        $this->addSql('DROP TABLE tz_facture');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tz_cms (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_cms_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, cmst_title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, cmst_content LONGTEXT NOT NULL COLLATE utf8_unicode_ci, cmst_slug VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, locale VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_4BABC32B86A085A0 (cmst_slug), UNIQUE INDEX tz_cms_translation_unique_translation (translatable_id, locale), INDEX IDX_4BABC32B2C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_devis (id INT AUTO_INCREMENT NOT NULL, tz_clt_id INT DEFAULT NULL, tz_usr_id INT DEFAULT NULL, dv_sujet VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, dv_desc LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, dv_date DATETIME DEFAULT NULL, dv_pj VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_B5FD4772CB45E20 (tz_clt_id), INDEX IDX_B5FD47721EE0E029 (tz_usr_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_facture (id INT AUTO_INCREMENT NOT NULL, tz_srv_clt_id INT DEFAULT NULL, fct_date DATETIME DEFAULT NULL, fct_status SMALLINT DEFAULT NULL, INDEX IDX_96495EDB83740837 (tz_srv_clt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tz_cms_translation ADD CONSTRAINT FK_4BABC32B2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES tz_cms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_devis ADD CONSTRAINT FK_B5FD47721EE0E029 FOREIGN KEY (tz_usr_id) REFERENCES tz_user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_devis ADD CONSTRAINT FK_B5FD4772CB45E20 FOREIGN KEY (tz_clt_id) REFERENCES tz_client (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_facture ADD CONSTRAINT FK_96495EDB83740837 FOREIGN KEY (tz_srv_clt_id) REFERENCES tz_service_client (id) ON DELETE SET NULL');
    }
}
