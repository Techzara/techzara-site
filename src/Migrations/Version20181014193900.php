<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181014193900 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tz_client (id INT AUTO_INCREMENT NOT NULL, clt_name VARCHAR(100) DEFAULT NULL, clt_firstname VARCHAR(100) DEFAULT NULL, clt_address VARCHAR(255) DEFAULT NULL, clt_tel VARCHAR(45) DEFAULT NULL, clt_mdp VARCHAR(255) DEFAULT NULL, clt_is_valid TINYINT(1) NOT NULL, clt_nom_entreprise VARCHAR(100) DEFAULT NULL, clt_last_connected DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_cms (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_cms_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, cmst_title VARCHAR(255) NOT NULL, cmst_content LONGTEXT NOT NULL, cmst_slug VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4BABC32B86A085A0 (cmst_slug), INDEX IDX_4BABC32B2C2AC5D3 (translatable_id), UNIQUE INDEX tz_cms_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_devis (id INT AUTO_INCREMENT NOT NULL, tz_clt_id INT DEFAULT NULL, tz_usr_id INT DEFAULT NULL, dv_sujet VARCHAR(100) DEFAULT NULL, dv_desc LONGTEXT DEFAULT NULL, dv_date DATETIME DEFAULT NULL, dv_pj VARCHAR(255) DEFAULT NULL, INDEX IDX_B5FD4772CB45E20 (tz_clt_id), INDEX IDX_B5FD47721EE0E029 (tz_usr_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_email_newsletter (id INT AUTO_INCREMENT NOT NULL, nws_email VARCHAR(45) NOT NULL, nws_subscribed TINYINT(1) DEFAULT \'1\', UNIQUE INDEX UNIQ_225BC762D5D52DEC (nws_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_facture (id INT AUTO_INCREMENT NOT NULL, tz_srv_clt_id INT DEFAULT NULL, fct_date DATETIME DEFAULT NULL, fct_status SMALLINT DEFAULT NULL, INDEX IDX_96495EDB83740837 (tz_srv_clt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_faq (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_faq_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, faqt_question LONGTEXT NOT NULL, faqt_response LONGTEXT NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_328559C62C2AC5D3 (translatable_id), UNIQUE INDEX tz_faq_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_message_newsletter (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_message_newsletter_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, message_newsletter_title VARCHAR(255) NOT NULL, message_newsletter_content LONGTEXT NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_DEC446972C2AC5D3 (translatable_id), UNIQUE INDEX tz_message_newsletter_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_news (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_news_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, cmst_title VARCHAR(255) NOT NULL, cmst_content LONGTEXT NOT NULL, cmst_slug VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6D31435586A085A0 (cmst_slug), INDEX IDX_6D3143552C2AC5D3 (translatable_id), UNIQUE INDEX tz_news_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_portfolio (id INT AUTO_INCREMENT NOT NULL, pf_tp_id INT DEFAULT NULL, pf_title VARCHAR(255) DEFAULT NULL, pf_url VARCHAR(255) DEFAULT NULL, pf_description VARCHAR(255) DEFAULT NULL, pf_image_url VARCHAR(255) DEFAULT NULL, pf_slug VARCHAR(255) NOT NULL, INDEX IDX_47EFAF9A22A177B5 (pf_tp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_portfolio_type (id INT AUTO_INCREMENT NOT NULL, pf_tp_label VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_role (id INT AUTO_INCREMENT NOT NULL, rl_name VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_service (id INT AUTO_INCREMENT NOT NULL, tz_srv_tp_id INT DEFAULT NULL, srv_label VARCHAR(255) DEFAULT NULL, srv_desc LONGTEXT DEFAULT NULL, srv_prix DOUBLE PRECISION DEFAULT NULL, srv_reduction DOUBLE PRECISION DEFAULT NULL, srv_slug VARCHAR(255) NOT NULL, INDEX IDX_8952A019A35D6729 (tz_srv_tp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_service_service_option (tz_srv_id INT NOT NULL, tz_srv_opt_id INT NOT NULL, INDEX IDX_508790587ABBBDD3 (tz_srv_id), INDEX IDX_5087905851A6B2CF (tz_srv_opt_id), PRIMARY KEY(tz_srv_id, tz_srv_opt_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_service_client (id INT AUTO_INCREMENT NOT NULL, tz_srv_id INT DEFAULT NULL, tz_clt_id INT DEFAULT NULL, tz_usr_id INT DEFAULT NULL, srv_clt_is_payed TINYINT(1) DEFAULT NULL, srv_clt_payment_type VARCHAR(45) DEFAULT NULL, srv_clt_payment_is_facture TINYINT(1) DEFAULT NULL, srv_clt_project_link VARCHAR(255) DEFAULT NULL, srv_clt_date DATETIME DEFAULT NULL, srv_clt_date_livraison_prev DATETIME DEFAULT NULL, srv_clt_date_livraison DATETIME DEFAULT NULL, srv_clt_desc LONGTEXT DEFAULT NULL, srv_clt_lien_code_source VARCHAR(255) DEFAULT NULL, srv_clt_lien_livre VARCHAR(255) DEFAULT NULL, srv_clt_nbr_page INT DEFAULT NULL, srv_clt_nbr_page_decline INT DEFAULT NULL, srv_clt_prix DOUBLE PRECISION DEFAULT NULL, srv_clt_status_validation SMALLINT DEFAULT 0, srv_clt_status_project SMALLINT DEFAULT 0, INDEX IDX_7AF4E3F7ABBBDD3 (tz_srv_id), INDEX IDX_7AF4E3FCB45E20 (tz_clt_id), INDEX IDX_7AF4E3F1EE0E029 (tz_usr_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_service_client_service_option (tz_srv_clt_id INT NOT NULL, tz_srv_opt_id INT NOT NULL, INDEX IDX_EAC9CA6C83740837 (tz_srv_clt_id), INDEX IDX_EAC9CA6C51A6B2CF (tz_srv_opt_id), PRIMARY KEY(tz_srv_clt_id, tz_srv_opt_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_service_client_jointe (id INT AUTO_INCREMENT NOT NULL, tz_srv_clt_id INT DEFAULT NULL, srv_clt_jt_ext VARCHAR(10) DEFAULT NULL, srv_clt_jt_path VARCHAR(255) DEFAULT NULL, INDEX IDX_8CC9735F83740837 (tz_srv_clt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_service_option (id INT AUTO_INCREMENT NOT NULL, tz_srv_opt_tp_id INT DEFAULT NULL, tz_srv_opt_val_tp_id INT DEFAULT NULL, srv_opt_label VARCHAR(255) DEFAULT NULL, srv_opt_desc LONGTEXT DEFAULT NULL, srv_opt_type VARCHAR(45) DEFAULT NULL, srv_opt_valeur DOUBLE PRECISION DEFAULT NULL, INDEX IDX_9A6D4ADA52FF4D00 (tz_srv_opt_tp_id), UNIQUE INDEX UNIQ_9A6D4ADA8D76555 (tz_srv_opt_val_tp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_service_option_type (id INT AUTO_INCREMENT NOT NULL, srv_opt_tp_label VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_service_option_valeur_type (id INT AUTO_INCREMENT NOT NULL, srv_opt_val_tp_is_percent TINYINT(1) DEFAULT NULL, srv_opt_val_tp_is_reduction TINYINT(1) DEFAULT NULL, srv_opt_val_tp_is_gratuit TINYINT(1) DEFAULT NULL, srv_opt_val_tp_val SMALLINT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_service_type (id INT AUTO_INCREMENT NOT NULL, srv_tp_label VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_slide (id INT AUTO_INCREMENT NOT NULL, sld_first_title VARCHAR(255) DEFAULT NULL, sld_second_title VARCHAR(255) DEFAULT NULL, sld_third_title VARCHAR(255) DEFAULT NULL, sld_image_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_temoignage (id INT AUTO_INCREMENT NOT NULL, tm_message LONGTEXT DEFAULT NULL, tm_nom_personne VARCHAR(255) DEFAULT NULL, tm_poste_personne VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_user_service_client (id INT AUTO_INCREMENT NOT NULL, tz_usr_admin_id INT DEFAULT NULL, tz_srv_clt_id INT DEFAULT NULL, usr_srv_clt_date_debut DATETIME DEFAULT NULL, usr_srv_clt_date_attribution DATETIME DEFAULT NULL, usr_srv_clt_estimation DOUBLE PRECISION DEFAULT NULL, usr_srv_clt_date_finalisation DATETIME DEFAULT NULL, INDEX IDX_17FAC72CC82673DF (tz_usr_admin_id), INDEX IDX_17FAC72C83740837 (tz_srv_clt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_user_service_client_user (tz_usr_srv_clt_id INT NOT NULL, tz_usr_id INT NOT NULL, INDEX IDX_82CDC078B624D5A0 (tz_usr_srv_clt_id), INDEX IDX_82CDC0781EE0E029 (tz_usr_id), PRIMARY KEY(tz_usr_srv_clt_id, tz_usr_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_user_service_client_tester (tz_usr_srv_clt_id INT NOT NULL, tz_tst_id INT NOT NULL, INDEX IDX_CED9EBF8B624D5A0 (tz_usr_srv_clt_id), INDEX IDX_CED9EBF8F0D76C50 (tz_tst_id), PRIMARY KEY(tz_usr_srv_clt_id, tz_tst_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tz_user (id INT AUTO_INCREMENT NOT NULL, tz_role_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', usr_firstname VARCHAR(255) DEFAULT NULL, usr_lastname VARCHAR(255) DEFAULT NULL, usr_address VARCHAR(255) DEFAULT NULL, usr_date_create DATETIME DEFAULT NULL, usr_date_update DATETIME DEFAULT NULL, usr_phone VARCHAR(45) DEFAULT NULL, usr_photo VARCHAR(255) DEFAULT NULL, usr_is_valid TINYINT(1) NOT NULL, usr_nom_entreprise VARCHAR(100) DEFAULT NULL, usr_tache VARCHAR(255) DEFAULT NULL, INDEX IDX_396654AEBECC1867 (tz_role_id), UNIQUE INDEX username_canonical_UNIQUE (username_canonical), UNIQUE INDEX email_canonical_UNIQUE (email_canonical), UNIQUE INDEX confirmation_token_UNIQUE (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tz_cms_translation ADD CONSTRAINT FK_4BABC32B2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES tz_cms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_devis ADD CONSTRAINT FK_B5FD4772CB45E20 FOREIGN KEY (tz_clt_id) REFERENCES tz_client (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_devis ADD CONSTRAINT FK_B5FD47721EE0E029 FOREIGN KEY (tz_usr_id) REFERENCES tz_user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_facture ADD CONSTRAINT FK_96495EDB83740837 FOREIGN KEY (tz_srv_clt_id) REFERENCES tz_service_client (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_faq_translation ADD CONSTRAINT FK_328559C62C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES tz_faq (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_message_newsletter_translation ADD CONSTRAINT FK_DEC446972C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES tz_message_newsletter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_news_translation ADD CONSTRAINT FK_6D3143552C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES tz_news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_portfolio ADD CONSTRAINT FK_47EFAF9A22A177B5 FOREIGN KEY (pf_tp_id) REFERENCES tz_portfolio_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_service ADD CONSTRAINT FK_8952A019A35D6729 FOREIGN KEY (tz_srv_tp_id) REFERENCES tz_service_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_service_service_option ADD CONSTRAINT FK_508790587ABBBDD3 FOREIGN KEY (tz_srv_id) REFERENCES tz_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_service_service_option ADD CONSTRAINT FK_5087905851A6B2CF FOREIGN KEY (tz_srv_opt_id) REFERENCES tz_service_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_service_client ADD CONSTRAINT FK_7AF4E3F7ABBBDD3 FOREIGN KEY (tz_srv_id) REFERENCES tz_service (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_service_client ADD CONSTRAINT FK_7AF4E3FCB45E20 FOREIGN KEY (tz_clt_id) REFERENCES tz_client (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_service_client ADD CONSTRAINT FK_7AF4E3F1EE0E029 FOREIGN KEY (tz_usr_id) REFERENCES tz_user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_service_client_service_option ADD CONSTRAINT FK_EAC9CA6C83740837 FOREIGN KEY (tz_srv_clt_id) REFERENCES tz_service_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_service_client_service_option ADD CONSTRAINT FK_EAC9CA6C51A6B2CF FOREIGN KEY (tz_srv_opt_id) REFERENCES tz_service_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_service_client_jointe ADD CONSTRAINT FK_8CC9735F83740837 FOREIGN KEY (tz_srv_clt_id) REFERENCES tz_service_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_service_option ADD CONSTRAINT FK_9A6D4ADA52FF4D00 FOREIGN KEY (tz_srv_opt_tp_id) REFERENCES tz_service_option_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_service_option ADD CONSTRAINT FK_9A6D4ADA8D76555 FOREIGN KEY (tz_srv_opt_val_tp_id) REFERENCES tz_service_option_valeur_type (id)');
        $this->addSql('ALTER TABLE tz_user_service_client ADD CONSTRAINT FK_17FAC72CC82673DF FOREIGN KEY (tz_usr_admin_id) REFERENCES tz_user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_user_service_client ADD CONSTRAINT FK_17FAC72C83740837 FOREIGN KEY (tz_srv_clt_id) REFERENCES tz_service_client (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_user_service_client_user ADD CONSTRAINT FK_82CDC078B624D5A0 FOREIGN KEY (tz_usr_srv_clt_id) REFERENCES tz_user_service_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_user_service_client_user ADD CONSTRAINT FK_82CDC0781EE0E029 FOREIGN KEY (tz_usr_id) REFERENCES tz_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_user_service_client_tester ADD CONSTRAINT FK_CED9EBF8B624D5A0 FOREIGN KEY (tz_usr_srv_clt_id) REFERENCES tz_user_service_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_user_service_client_tester ADD CONSTRAINT FK_CED9EBF8F0D76C50 FOREIGN KEY (tz_tst_id) REFERENCES tz_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_user ADD CONSTRAINT FK_396654AEBECC1867 FOREIGN KEY (tz_role_id) REFERENCES tz_role (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tz_devis DROP FOREIGN KEY FK_B5FD4772CB45E20');
        $this->addSql('ALTER TABLE tz_service_client DROP FOREIGN KEY FK_7AF4E3FCB45E20');
        $this->addSql('ALTER TABLE tz_cms_translation DROP FOREIGN KEY FK_4BABC32B2C2AC5D3');
        $this->addSql('ALTER TABLE tz_faq_translation DROP FOREIGN KEY FK_328559C62C2AC5D3');
        $this->addSql('ALTER TABLE tz_message_newsletter_translation DROP FOREIGN KEY FK_DEC446972C2AC5D3');
        $this->addSql('ALTER TABLE tz_news_translation DROP FOREIGN KEY FK_6D3143552C2AC5D3');
        $this->addSql('ALTER TABLE tz_portfolio DROP FOREIGN KEY FK_47EFAF9A22A177B5');
        $this->addSql('ALTER TABLE tz_user DROP FOREIGN KEY FK_396654AEBECC1867');
        $this->addSql('ALTER TABLE tz_service_service_option DROP FOREIGN KEY FK_508790587ABBBDD3');
        $this->addSql('ALTER TABLE tz_service_client DROP FOREIGN KEY FK_7AF4E3F7ABBBDD3');
        $this->addSql('ALTER TABLE tz_facture DROP FOREIGN KEY FK_96495EDB83740837');
        $this->addSql('ALTER TABLE tz_service_client_service_option DROP FOREIGN KEY FK_EAC9CA6C83740837');
        $this->addSql('ALTER TABLE tz_service_client_jointe DROP FOREIGN KEY FK_8CC9735F83740837');
        $this->addSql('ALTER TABLE tz_user_service_client DROP FOREIGN KEY FK_17FAC72C83740837');
        $this->addSql('ALTER TABLE tz_service_service_option DROP FOREIGN KEY FK_5087905851A6B2CF');
        $this->addSql('ALTER TABLE tz_service_client_service_option DROP FOREIGN KEY FK_EAC9CA6C51A6B2CF');
        $this->addSql('ALTER TABLE tz_service_option DROP FOREIGN KEY FK_9A6D4ADA52FF4D00');
        $this->addSql('ALTER TABLE tz_service_option DROP FOREIGN KEY FK_9A6D4ADA8D76555');
        $this->addSql('ALTER TABLE tz_service DROP FOREIGN KEY FK_8952A019A35D6729');
        $this->addSql('ALTER TABLE tz_user_service_client_user DROP FOREIGN KEY FK_82CDC078B624D5A0');
        $this->addSql('ALTER TABLE tz_user_service_client_tester DROP FOREIGN KEY FK_CED9EBF8B624D5A0');
        $this->addSql('ALTER TABLE tz_devis DROP FOREIGN KEY FK_B5FD47721EE0E029');
        $this->addSql('ALTER TABLE tz_service_client DROP FOREIGN KEY FK_7AF4E3F1EE0E029');
        $this->addSql('ALTER TABLE tz_user_service_client DROP FOREIGN KEY FK_17FAC72CC82673DF');
        $this->addSql('ALTER TABLE tz_user_service_client_user DROP FOREIGN KEY FK_82CDC0781EE0E029');
        $this->addSql('ALTER TABLE tz_user_service_client_tester DROP FOREIGN KEY FK_CED9EBF8F0D76C50');
        $this->addSql('DROP TABLE tz_client');
        $this->addSql('DROP TABLE tz_cms');
        $this->addSql('DROP TABLE tz_cms_translation');
        $this->addSql('DROP TABLE tz_devis');
        $this->addSql('DROP TABLE tz_email_newsletter');
        $this->addSql('DROP TABLE tz_facture');
        $this->addSql('DROP TABLE tz_faq');
        $this->addSql('DROP TABLE tz_faq_translation');
        $this->addSql('DROP TABLE tz_message_newsletter');
        $this->addSql('DROP TABLE tz_message_newsletter_translation');
        $this->addSql('DROP TABLE tz_news');
        $this->addSql('DROP TABLE tz_news_translation');
        $this->addSql('DROP TABLE tz_portfolio');
        $this->addSql('DROP TABLE tz_portfolio_type');
        $this->addSql('DROP TABLE tz_role');
        $this->addSql('DROP TABLE tz_service');
        $this->addSql('DROP TABLE tz_service_service_option');
        $this->addSql('DROP TABLE tz_service_client');
        $this->addSql('DROP TABLE tz_service_client_service_option');
        $this->addSql('DROP TABLE tz_service_client_jointe');
        $this->addSql('DROP TABLE tz_service_option');
        $this->addSql('DROP TABLE tz_service_option_type');
        $this->addSql('DROP TABLE tz_service_option_valeur_type');
        $this->addSql('DROP TABLE tz_service_type');
        $this->addSql('DROP TABLE tz_slide');
        $this->addSql('DROP TABLE tz_temoignage');
        $this->addSql('DROP TABLE tz_user_service_client');
        $this->addSql('DROP TABLE tz_user_service_client_user');
        $this->addSql('DROP TABLE tz_user_service_client_tester');
        $this->addSql('DROP TABLE tz_user');
    }
}
