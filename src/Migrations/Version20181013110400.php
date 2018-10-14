<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181013110400 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tz_cms_translation ADD CONSTRAINT FK_4BABC32B2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES tz_cms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_cms_translation RENAME INDEX uniq_e741596e86a085a0 TO UNIQ_4BABC32B86A085A0');
        $this->addSql('ALTER TABLE tz_cms_translation RENAME INDEX idx_e741596e2c2ac5d3 TO IDX_4BABC32B2C2AC5D3');
        $this->addSql('ALTER TABLE tz_devis ADD CONSTRAINT FK_B5FD4772CB45E20 FOREIGN KEY (tz_clt_id) REFERENCES tz_client (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_devis ADD CONSTRAINT FK_B5FD47721EE0E029 FOREIGN KEY (tz_usr_id) REFERENCES tz_user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_devis RENAME INDEX idx_dd0307984c03ab06 TO IDX_B5FD4772CB45E20');
        $this->addSql('ALTER TABLE tz_devis RENAME INDEX idx_dd0307985e57150f TO IDX_B5FD47721EE0E029');
        $this->addSql('ALTER TABLE tz_email_newsletter RENAME INDEX uniq_244198e7d5d52dec TO UNIQ_225BC762D5D52DEC');
        $this->addSql('ALTER TABLE tz_facture ADD CONSTRAINT FK_96495EDB83740837 FOREIGN KEY (tz_srv_clt_id) REFERENCES tz_service_client (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_facture RENAME INDEX idx_44046cd3687a3001 TO IDX_96495EDB83740837');
        $this->addSql('ALTER TABLE tz_faq_translation ADD CONSTRAINT FK_328559C62C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES tz_faq (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_faq_translation RENAME INDEX idx_9e6fc3832c2ac5d3 TO IDX_328559C62C2AC5D3');
        $this->addSql('ALTER TABLE tz_message_newsletter_translation ADD CONSTRAINT FK_DEC446972C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES tz_message_newsletter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_message_newsletter_translation RENAME INDEX idx_f974ea822c2ac5d3 TO IDX_DEC446972C2AC5D3');
        $this->addSql('ALTER TABLE tz_news_translation ADD CONSTRAINT FK_6D3143552C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES tz_news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_news_translation RENAME INDEX uniq_6b2b1cd086a085a0 TO UNIQ_6D31435586A085A0');
        $this->addSql('ALTER TABLE tz_news_translation RENAME INDEX idx_6b2b1cd02c2ac5d3 TO IDX_6D3143552C2AC5D3');
        $this->addSql('ALTER TABLE tz_portfolio ADD CONSTRAINT FK_47EFAF9A22A177B5 FOREIGN KEY (pf_tp_id) REFERENCES tz_portfolio_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_portfolio RENAME INDEX idx_47e1a65f22a177b5 TO IDX_47EFAF9A22A177B5');
        $this->addSql('ALTER TABLE tz_service ADD CONSTRAINT FK_8952A019A35D6729 FOREIGN KEY (tz_srv_tp_id) REFERENCES tz_service_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_service RENAME INDEX idx_5b1f9211a3536eec TO IDX_8952A019A35D6729');
        $this->addSql('ALTER TABLE tz_service_service_option ADD CONSTRAINT FK_508790587ABBBDD3 FOREIGN KEY (tz_srv_id) REFERENCES tz_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_service_service_option ADD CONSTRAINT FK_5087905851A6B2CF FOREIGN KEY (tz_srv_opt_id) REFERENCES tz_service_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_service_service_option RENAME INDEX idx_9f9086603a0c48f5 TO IDX_508790587ABBBDD3');
        $this->addSql('ALTER TABLE tz_service_service_option RENAME INDEX idx_9f908660baa88af9 TO IDX_5087905851A6B2CF');
        $this->addSql('ALTER TABLE tz_service_client ADD CONSTRAINT FK_7AF4E3F7ABBBDD3 FOREIGN KEY (tz_srv_id) REFERENCES tz_service (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_service_client ADD CONSTRAINT FK_7AF4E3FCB45E20 FOREIGN KEY (tz_clt_id) REFERENCES tz_client (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_service_client ADD CONSTRAINT FK_7AF4E3F1EE0E029 FOREIGN KEY (tz_usr_id) REFERENCES tz_user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_service_client RENAME INDEX idx_51cc4b143a0c48f5 TO IDX_7AF4E3F7ABBBDD3');
        $this->addSql('ALTER TABLE tz_service_client RENAME INDEX idx_51cc4b144c03ab06 TO IDX_7AF4E3FCB45E20');
        $this->addSql('ALTER TABLE tz_service_client RENAME INDEX idx_51cc4b145e57150f TO IDX_7AF4E3F1EE0E029');
        $this->addSql('ALTER TABLE tz_service_client_service_option ADD CONSTRAINT FK_EAC9CA6C83740837 FOREIGN KEY (tz_srv_clt_id) REFERENCES tz_service_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_service_client_service_option ADD CONSTRAINT FK_EAC9CA6C51A6B2CF FOREIGN KEY (tz_srv_opt_id) REFERENCES tz_service_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_service_client_service_option RENAME INDEX idx_5824751d687a3001 TO IDX_EAC9CA6C83740837');
        $this->addSql('ALTER TABLE tz_service_client_service_option RENAME INDEX idx_5824751dbaa88af9 TO IDX_EAC9CA6C51A6B2CF');
        $this->addSql('ALTER TABLE tz_service_client_jointe ADD CONSTRAINT FK_8CC9735F83740837 FOREIGN KEY (tz_srv_clt_id) REFERENCES tz_service_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_service_client_jointe RENAME INDEX idx_214ad269687a3001 TO IDX_8CC9735F83740837');
        $this->addSql('ALTER TABLE tz_service_option ADD CONSTRAINT FK_9A6D4ADA52FF4D00 FOREIGN KEY (tz_srv_opt_tp_id) REFERENCES tz_service_option_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_service_option ADD CONSTRAINT FK_9A6D4ADA8D76555 FOREIGN KEY (tz_srv_opt_val_tp_id) REFERENCES tz_service_option_valeur_type (id)');
        $this->addSql('ALTER TABLE tz_service_option RENAME INDEX idx_cc0e4ff1823e4535 TO IDX_9A6D4ADA52FF4D00');
        $this->addSql('ALTER TABLE tz_service_option RENAME INDEX uniq_cc0e4ff1950308a5 TO UNIQ_9A6D4ADA8D76555');
        $this->addSql('ALTER TABLE tz_user_service_client ADD CONSTRAINT FK_17FAC72CC82673DF FOREIGN KEY (tz_usr_admin_id) REFERENCES tz_user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_user_service_client ADD CONSTRAINT FK_17FAC72C83740837 FOREIGN KEY (tz_srv_clt_id) REFERENCES tz_service_client (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tz_user_service_client RENAME INDEX idx_3045a6a06938b13a TO IDX_17FAC72CC82673DF');
        $this->addSql('ALTER TABLE tz_user_service_client RENAME INDEX idx_3045a6a0687a3001 TO IDX_17FAC72C83740837');
        $this->addSql('ALTER TABLE tz_user_service_client_user ADD CONSTRAINT FK_82CDC078B624D5A0 FOREIGN KEY (tz_usr_srv_clt_id) REFERENCES tz_user_service_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_user_service_client_user ADD CONSTRAINT FK_82CDC0781EE0E029 FOREIGN KEY (tz_usr_id) REFERENCES tz_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_user_service_client_user RENAME INDEX idx_618606c5e047d08b TO IDX_82CDC078B624D5A0');
        $this->addSql('ALTER TABLE tz_user_service_client_user RENAME INDEX idx_618606c55e57150f TO IDX_82CDC0781EE0E029');
        $this->addSql('ALTER TABLE tz_user_service_client_tester ADD CONSTRAINT FK_CED9EBF8B624D5A0 FOREIGN KEY (tz_usr_srv_clt_id) REFERENCES tz_user_service_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_user_service_client_tester ADD CONSTRAINT FK_CED9EBF8F0D76C50 FOREIGN KEY (tz_tst_id) REFERENCES tz_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tz_user_service_client_tester RENAME INDEX idx_edb5bfc3e047d08b TO IDX_CED9EBF8B624D5A0');
        $this->addSql('ALTER TABLE tz_user_service_client_tester RENAME INDEX idx_edb5bfc3b0609976 TO IDX_CED9EBF8F0D76C50');
        $this->addSql('ALTER TABLE tz_user ADD CONSTRAINT FK_396654AEBECC1867 FOREIGN KEY (tz_role_id) REFERENCES tz_role (id)');
        $this->addSql('ALTER TABLE tz_user RENAME INDEX idx_1a95467c6c812a6f TO IDX_396654AEBECC1867');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tz_cms_translation DROP FOREIGN KEY FK_4BABC32B2C2AC5D3');
        $this->addSql('ALTER TABLE tz_cms_translation RENAME INDEX uniq_4babc32b86a085a0 TO UNIQ_E741596E86A085A0');
        $this->addSql('ALTER TABLE tz_cms_translation RENAME INDEX idx_4babc32b2c2ac5d3 TO IDX_E741596E2C2AC5D3');
        $this->addSql('ALTER TABLE tz_devis DROP FOREIGN KEY FK_B5FD4772CB45E20');
        $this->addSql('ALTER TABLE tz_devis DROP FOREIGN KEY FK_B5FD47721EE0E029');
        $this->addSql('ALTER TABLE tz_devis RENAME INDEX idx_b5fd4772cb45e20 TO IDX_DD0307984C03AB06');
        $this->addSql('ALTER TABLE tz_devis RENAME INDEX idx_b5fd47721ee0e029 TO IDX_DD0307985E57150F');
        $this->addSql('ALTER TABLE tz_email_newsletter RENAME INDEX uniq_225bc762d5d52dec TO UNIQ_244198E7D5D52DEC');
        $this->addSql('ALTER TABLE tz_facture DROP FOREIGN KEY FK_96495EDB83740837');
        $this->addSql('ALTER TABLE tz_facture RENAME INDEX idx_96495edb83740837 TO IDX_44046CD3687A3001');
        $this->addSql('ALTER TABLE tz_faq_translation DROP FOREIGN KEY FK_328559C62C2AC5D3');
        $this->addSql('ALTER TABLE tz_faq_translation RENAME INDEX idx_328559c62c2ac5d3 TO IDX_9E6FC3832C2AC5D3');
        $this->addSql('ALTER TABLE tz_message_newsletter_translation DROP FOREIGN KEY FK_DEC446972C2AC5D3');
        $this->addSql('ALTER TABLE tz_message_newsletter_translation RENAME INDEX idx_dec446972c2ac5d3 TO IDX_F974EA822C2AC5D3');
        $this->addSql('ALTER TABLE tz_news_translation DROP FOREIGN KEY FK_6D3143552C2AC5D3');
        $this->addSql('ALTER TABLE tz_news_translation RENAME INDEX uniq_6d31435586a085a0 TO UNIQ_6B2B1CD086A085A0');
        $this->addSql('ALTER TABLE tz_news_translation RENAME INDEX idx_6d3143552c2ac5d3 TO IDX_6B2B1CD02C2AC5D3');
        $this->addSql('ALTER TABLE tz_portfolio DROP FOREIGN KEY FK_47EFAF9A22A177B5');
        $this->addSql('ALTER TABLE tz_portfolio RENAME INDEX idx_47efaf9a22a177b5 TO IDX_47E1A65F22A177B5');
        $this->addSql('ALTER TABLE tz_service DROP FOREIGN KEY FK_8952A019A35D6729');
        $this->addSql('ALTER TABLE tz_service RENAME INDEX idx_8952a019a35d6729 TO IDX_5B1F9211A3536EEC');
        $this->addSql('ALTER TABLE tz_service_client DROP FOREIGN KEY FK_7AF4E3F7ABBBDD3');
        $this->addSql('ALTER TABLE tz_service_client DROP FOREIGN KEY FK_7AF4E3FCB45E20');
        $this->addSql('ALTER TABLE tz_service_client DROP FOREIGN KEY FK_7AF4E3F1EE0E029');
        $this->addSql('ALTER TABLE tz_service_client RENAME INDEX idx_7af4e3f7abbbdd3 TO IDX_51CC4B143A0C48F5');
        $this->addSql('ALTER TABLE tz_service_client RENAME INDEX idx_7af4e3fcb45e20 TO IDX_51CC4B144C03AB06');
        $this->addSql('ALTER TABLE tz_service_client RENAME INDEX idx_7af4e3f1ee0e029 TO IDX_51CC4B145E57150F');
        $this->addSql('ALTER TABLE tz_service_client_jointe DROP FOREIGN KEY FK_8CC9735F83740837');
        $this->addSql('ALTER TABLE tz_service_client_jointe RENAME INDEX idx_8cc9735f83740837 TO IDX_214AD269687A3001');
        $this->addSql('ALTER TABLE tz_service_client_service_option DROP FOREIGN KEY FK_EAC9CA6C83740837');
        $this->addSql('ALTER TABLE tz_service_client_service_option DROP FOREIGN KEY FK_EAC9CA6C51A6B2CF');
        $this->addSql('ALTER TABLE tz_service_client_service_option RENAME INDEX idx_eac9ca6c83740837 TO IDX_5824751D687A3001');
        $this->addSql('ALTER TABLE tz_service_client_service_option RENAME INDEX idx_eac9ca6c51a6b2cf TO IDX_5824751DBAA88AF9');
        $this->addSql('ALTER TABLE tz_service_option DROP FOREIGN KEY FK_9A6D4ADA52FF4D00');
        $this->addSql('ALTER TABLE tz_service_option DROP FOREIGN KEY FK_9A6D4ADA8D76555');
        $this->addSql('ALTER TABLE tz_service_option RENAME INDEX uniq_9a6d4ada8d76555 TO UNIQ_CC0E4FF1950308A5');
        $this->addSql('ALTER TABLE tz_service_option RENAME INDEX idx_9a6d4ada52ff4d00 TO IDX_CC0E4FF1823E4535');
        $this->addSql('ALTER TABLE tz_service_service_option DROP FOREIGN KEY FK_508790587ABBBDD3');
        $this->addSql('ALTER TABLE tz_service_service_option DROP FOREIGN KEY FK_5087905851A6B2CF');
        $this->addSql('ALTER TABLE tz_service_service_option RENAME INDEX idx_508790587abbbdd3 TO IDX_9F9086603A0C48F5');
        $this->addSql('ALTER TABLE tz_service_service_option RENAME INDEX idx_5087905851a6b2cf TO IDX_9F908660BAA88AF9');
        $this->addSql('ALTER TABLE tz_user DROP FOREIGN KEY FK_396654AEBECC1867');
        $this->addSql('ALTER TABLE tz_user RENAME INDEX idx_396654aebecc1867 TO IDX_1A95467C6C812A6F');
        $this->addSql('ALTER TABLE tz_user_service_client DROP FOREIGN KEY FK_17FAC72CC82673DF');
        $this->addSql('ALTER TABLE tz_user_service_client DROP FOREIGN KEY FK_17FAC72C83740837');
        $this->addSql('ALTER TABLE tz_user_service_client RENAME INDEX idx_17fac72cc82673df TO IDX_3045A6A06938B13A');
        $this->addSql('ALTER TABLE tz_user_service_client RENAME INDEX idx_17fac72c83740837 TO IDX_3045A6A0687A3001');
        $this->addSql('ALTER TABLE tz_user_service_client_tester DROP FOREIGN KEY FK_CED9EBF8B624D5A0');
        $this->addSql('ALTER TABLE tz_user_service_client_tester DROP FOREIGN KEY FK_CED9EBF8F0D76C50');
        $this->addSql('ALTER TABLE tz_user_service_client_tester RENAME INDEX idx_ced9ebf8b624d5a0 TO IDX_EDB5BFC3E047D08B');
        $this->addSql('ALTER TABLE tz_user_service_client_tester RENAME INDEX idx_ced9ebf8f0d76c50 TO IDX_EDB5BFC3B0609976');
        $this->addSql('ALTER TABLE tz_user_service_client_user DROP FOREIGN KEY FK_82CDC078B624D5A0');
        $this->addSql('ALTER TABLE tz_user_service_client_user DROP FOREIGN KEY FK_82CDC0781EE0E029');
        $this->addSql('ALTER TABLE tz_user_service_client_user RENAME INDEX idx_82cdc078b624d5a0 TO IDX_618606C5E047D08B');
        $this->addSql('ALTER TABLE tz_user_service_client_user RENAME INDEX idx_82cdc0781ee0e029 TO IDX_618606C55E57150F');
    }
}
