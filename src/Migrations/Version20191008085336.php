<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191008085336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE stoke (id INT AUTO_INCREMENT NOT NULL, stoke INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE marc_concurent_pdv_tposm');
        $this->addSql('ALTER TABLE info_client CHANGE situation_famil_id situation_famil_id INT DEFAULT NULL, CHANGE age_client_id age_client_id INT DEFAULT NULL, CHANGE nbr_enfant_id nbr_enfant_id INT DEFAULT NULL, CHANGE type_client_new_id type_client_new_id INT DEFAULT NULL, CHANGE client_id client_id INT DEFAULT NULL, CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE telephone telephone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE client_mini_report CHANGE closed_reason_id closed_reason_id INT DEFAULT NULL, CHANGE closed_reason_autre closed_reason_autre VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE situation_familialle CHANGE sitation sitation VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE photos CHANGE perso_id perso_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE presence_ppsom_jti CHANGE is_present is_present TINYINT(1) DEFAULT NULL, CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stoke_sheet CHANGE stoke_sheet stoke_sheet VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE presence_shop_jti CHANGE is_present is_present TINYINT(1) DEFAULT NULL, CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE global_planning CHANGE day1 day1 INT DEFAULT NULL, CHANGE day2 day2 INT DEFAULT NULL, CHANGE day3 day3 INT DEFAULT NULL, CHANGE day4 day4 INT DEFAULT NULL, CHANGE day5 day5 INT DEFAULT NULL, CHANGE day6 day6 INT DEFAULT NULL, CHANGE day7 day7 INT DEFAULT NULL, CHANGE day8 day8 INT DEFAULT NULL, CHANGE day9 day9 INT DEFAULT NULL, CHANGE day10 day10 INT DEFAULT NULL, CHANGE day11 day11 INT DEFAULT NULL, CHANGE day12 day12 INT DEFAULT NULL, CHANGE day13 day13 INT DEFAULT NULL');
        $this->addSql('ALTER TABLE routing CHANGE zone_id zone_id INT DEFAULT NULL, CHANGE information information VARCHAR(255) DEFAULT NULL, CHANGE nbrs_pdv nbrs_pdv INT DEFAULT NULL, CHANGE merch merch VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE age CHANGE age age VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE presence_presentoire_jti CHANGE pdv_presentoire_id pdv_presentoire_id INT DEFAULT NULL, CHANGE is_present is_present TINYINT(1) DEFAULT NULL, CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE one_planning CHANGE date date DATETIME DEFAULT NULL, CHANGE a a INT DEFAULT NULL, CHANGE am am INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pdv_tposm CHANGE image_id image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE des_install_presentoire_jti CHANGE presentoire_id presentoire_id INT DEFAULT NULL, CHANGE is_desinstall is_desinstall TINYINT(1) DEFAULT NULL, CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE survey CHANGE cycle cycle INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plv_temporaire CHANGE quantiter_type_plv_id quantiter_type_plv_id INT DEFAULT NULL, CHANGE is_temporaire is_temporaire TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE user_name_admin user_name_admin VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_produit CHANGE rapport_global_id rapport_global_id INT DEFAULT NULL, CHANGE is_veder is_veder TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_maintenance CHANGE rapport_global_id rapport_global_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_global CHANGE rapport_pdv_id rapport_pdv_id INT DEFAULT NULL, CHANGE rapport_pposm_id rapport_pposm_id INT DEFAULT NULL, CHANGE rapport_tposm_id rapport_tposm_id INT DEFAULT NULL, CHANGE rapport_tlp_id rapport_tlp_id INT DEFAULT NULL, CHANGE merch_id merch_id INT DEFAULT NULL, CHANGE durre durre VARCHAR(255) DEFAULT NULL, CHANGE date_rappoort date_rappoort DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE presence_presentoire_not_jti CHANGE is_present is_present TINYINT(1) DEFAULT NULL, CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pdv_shop CHANGE image_id image_id INT DEFAULT NULL, CHANGE shop shop VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE file CHANGE client_mini_report_id client_mini_report_id INT DEFAULT NULL, CHANGE client_id client_id INT DEFAULT NULL, CHANGE label label VARCHAR(255) DEFAULT NULL, CHANGE path path VARCHAR(255) DEFAULT NULL, CHANGE classment classment VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pdv_ppsom CHANGE ppsom ppsom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE merch CHANGE region_id region_id INT DEFAULT NULL, CHANGE roles roles JSON DEFAULT NULL, CHANGE path_image path_image VARCHAR(255) DEFAULT NULL, CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE quantiter_type_plv CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_plv CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE type_client CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE install_presentoire_jti CHANGE presentoire_id presentoire_id INT DEFAULT NULL, CHANGE is_installation is_installation TINYINT(1) DEFAULT NULL, CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE new_install_pdv_comments CHANGE merch_status_comment merch_status_comment INT DEFAULT NULL, CHANGE modified_image modified_image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE produit CHANGE typeproduit_id typeproduit_id INT DEFAULT NULL, CHANGE file_id file_id INT DEFAULT NULL, CHANGE stoke stoke INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client CHANGE superficie_id superficie_id INT DEFAULT NULL, CHANGE emplacement_id emplacement_id INT DEFAULT NULL, CHANGE environnement_id environnement_id INT DEFAULT NULL, CHANGE type_de_quartier_id type_de_quartier_id INT DEFAULT NULL, CHANGE visibiliter_id visibiliter_id INT DEFAULT NULL, CHANGE classe_id classe_id INT DEFAULT NULL, CHANGE typologie_id typologie_id INT DEFAULT NULL, CHANGE presentoire_id presentoire_id INT DEFAULT NULL, CHANGE quartier_id quartier_id INT DEFAULT NULL, CHANGE regie_tabac_id regie_tabac_id INT DEFAULT NULL, CHANGE companie_oncour_id companie_oncour_id INT DEFAULT NULL, CHANGE recette_id recette_id INT DEFAULT NULL, CHANGE nbr_emplyer_id nbr_emplyer_id INT DEFAULT NULL, CHANGE sheet_client_id sheet_client_id INT DEFAULT NULL, CHANGE decider_id decider_id INT DEFAULT NULL, CHANGE code_client code_client INT DEFAULT NULL, CHANGE licence licence VARCHAR(255) DEFAULT NULL, CHANGE adress adress VARCHAR(255) DEFAULT NULL, CHANGE recette_p recette_p VARCHAR(255) DEFAULT NULL, CHANGE recette_s recette_s VARCHAR(255) DEFAULT NULL, CHANGE code_postal code_postal VARCHAR(255) DEFAULT NULL, CHANGE latitude latitude DOUBLE PRECISION DEFAULT NULL, CHANGE longitude longitude DOUBLE PRECISION DEFAULT NULL, CHANGE info_acc_pdv info_acc_pdv TINYINT(1) DEFAULT NULL, CHANGE date_signature date_signature VARCHAR(255) DEFAULT NULL, CHANGE date_rappoort date_rappoort VARCHAR(255) DEFAULT NULL, CHANGE date_instalation date_instalation VARCHAR(255) DEFAULT NULL, CHANGE is_tlp is_tlp TINYINT(1) DEFAULT NULL, CHANGE vendeur vendeur VARCHAR(255) DEFAULT NULL, CHANGE jour_visite jour_visite VARCHAR(255) DEFAULT NULL, CHANGE is_active is_active TINYINT(1) DEFAULT NULL, CHANGE is_one_to_one is_one_to_one TINYINT(1) DEFAULT NULL, CHANGE is_fs_potentiel is_fs_potentiel TINYINT(1) DEFAULT NULL, CHANGE cin cin VARCHAR(255) DEFAULT NULL, CHANGE num_licence num_licence VARCHAR(255) DEFAULT NULL, CHANGE ville ville VARCHAR(255) DEFAULT NULL, CHANGE nmb_affectation nmb_affectation INT DEFAULT NULL, CHANGE merch_id merch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE praisontoir_maison_de_maire CHANGE maison_de_maire maison_de_maire VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE desinstallation_presentoire_not_jti CHANGE is_desinstall is_desinstall TINYINT(1) DEFAULT NULL, CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE raison_presontoire CHANGE raison raison VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE list_install_pdv CHANGE install_day install_day VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_marketing CHANGE type_de_compagnie_id type_de_compagnie_id INT DEFAULT NULL, CHANGE nouvel_equipment_id nouvel_equipment_id INT DEFAULT NULL, CHANGE rapport_global_id rapport_global_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire CHANGE type_id type_id INT DEFAULT NULL, CHANGE client_id client_id INT DEFAULT NULL, CHANGE rapport_pposm_id rapport_pposm_id INT DEFAULT NULL, CHANGE rapport_tlp_id rapport_tlp_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_pposm CHANGE client_id client_id INT DEFAULT NULL, CHANGE merch_id merch_id INT DEFAULT NULL, CHANGE install_presentoire_jti_id install_presentoire_jti_id INT DEFAULT NULL, CHANGE des_install_presentoire_jti_id des_install_presentoire_jti_id INT DEFAULT NULL, CHANGE presence_presentoire_jti_id presence_presentoire_jti_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_tposm CHANGE presence_nbr_article_id presence_nbr_article_id INT DEFAULT NULL, CHANGE installation_nbr_id installation_nbr_id INT DEFAULT NULL, CHANGE instalation_raison_id instalation_raison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pdv_presentoire CHANGE image_id image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE new_install_pdv CHANGE code_client code_client INT DEFAULT NULL, CHANGE licence licence VARCHAR(255) DEFAULT NULL, CHANGE adress adress VARCHAR(255) DEFAULT NULL, CHANGE titulairenom titulairenom VARCHAR(255) DEFAULT NULL, CHANGE titulairetel titulairetel VARCHAR(255) DEFAULT NULL, CHANGE gerantnom gerantnom VARCHAR(255) DEFAULT NULL, CHANGE geranttel geranttel VARCHAR(255) DEFAULT NULL, CHANGE operateurnom operateurnom VARCHAR(255) DEFAULT NULL, CHANGE operateurtel operateurtel VARCHAR(255) DEFAULT NULL, CHANGE cin cin VARCHAR(255) DEFAULT NULL, CHANGE code_postal code_postal VARCHAR(255) DEFAULT NULL, CHANGE comment comment VARCHAR(255) DEFAULT NULL, CHANGE routings routings LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE comment_plv comment_plv VARCHAR(255) DEFAULT NULL, CHANGE plv plv LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE marc_concurent_pdv_tposm (marc_concurent_id INT NOT NULL, pdv_tposm_id INT NOT NULL, INDEX IDX_7D6BE5D13AC08274 (pdv_tposm_id), INDEX IDX_7D6BE5D1E5004D42 (marc_concurent_id), PRIMARY KEY(marc_concurent_id, pdv_tposm_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE marc_concurent_pdv_tposm ADD CONSTRAINT FK_7D6BE5D13AC08274 FOREIGN KEY (pdv_tposm_id) REFERENCES pdv_tposm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marc_concurent_pdv_tposm ADD CONSTRAINT FK_7D6BE5D1E5004D42 FOREIGN KEY (marc_concurent_id) REFERENCES marc_concurent (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE stoke');
        $this->addSql('ALTER TABLE age CHANGE age age VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE client CHANGE superficie_id superficie_id INT DEFAULT NULL, CHANGE emplacement_id emplacement_id INT DEFAULT NULL, CHANGE environnement_id environnement_id INT DEFAULT NULL, CHANGE type_de_quartier_id type_de_quartier_id INT DEFAULT NULL, CHANGE visibiliter_id visibiliter_id INT DEFAULT NULL, CHANGE classe_id classe_id INT DEFAULT NULL, CHANGE typologie_id typologie_id INT DEFAULT NULL, CHANGE presentoire_id presentoire_id INT DEFAULT NULL, CHANGE quartier_id quartier_id INT DEFAULT NULL, CHANGE regie_tabac_id regie_tabac_id INT DEFAULT NULL, CHANGE companie_oncour_id companie_oncour_id INT DEFAULT NULL, CHANGE recette_id recette_id INT DEFAULT NULL, CHANGE nbr_emplyer_id nbr_emplyer_id INT DEFAULT NULL, CHANGE sheet_client_id sheet_client_id INT DEFAULT NULL, CHANGE decider_id decider_id INT DEFAULT NULL, CHANGE code_client code_client INT DEFAULT NULL, CHANGE licence licence VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE adress adress VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE recette_p recette_p VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE recette_s recette_s VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE code_postal code_postal VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE latitude latitude DOUBLE PRECISION DEFAULT \'NULL\', CHANGE longitude longitude DOUBLE PRECISION DEFAULT \'NULL\', CHANGE info_acc_pdv info_acc_pdv TINYINT(1) DEFAULT \'NULL\', CHANGE date_signature date_signature VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE date_rappoort date_rappoort VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE date_instalation date_instalation VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE is_tlp is_tlp TINYINT(1) DEFAULT \'NULL\', CHANGE vendeur vendeur VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE jour_visite jour_visite VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE is_active is_active TINYINT(1) DEFAULT \'NULL\', CHANGE is_one_to_one is_one_to_one TINYINT(1) DEFAULT \'NULL\', CHANGE is_fs_potentiel is_fs_potentiel TINYINT(1) DEFAULT \'NULL\', CHANGE cin cin VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE num_licence num_licence VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE ville ville VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE nmb_affectation nmb_affectation INT DEFAULT NULL, CHANGE merch_id merch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client_mini_report CHANGE closed_reason_id closed_reason_id INT DEFAULT NULL, CHANGE closed_reason_autre closed_reason_autre VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE commentaire CHANGE type_id type_id INT DEFAULT NULL, CHANGE client_id client_id INT DEFAULT NULL, CHANGE rapport_pposm_id rapport_pposm_id INT DEFAULT NULL, CHANGE rapport_tlp_id rapport_tlp_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE des_install_presentoire_jti CHANGE presentoire_id presentoire_id INT DEFAULT NULL, CHANGE is_desinstall is_desinstall TINYINT(1) DEFAULT \'NULL\', CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE desinstallation_presentoire_not_jti CHANGE is_desinstall is_desinstall TINYINT(1) DEFAULT \'NULL\', CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE file CHANGE client_mini_report_id client_mini_report_id INT DEFAULT NULL, CHANGE client_id client_id INT DEFAULT NULL, CHANGE label label VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE path path VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE classment classment VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE global_planning CHANGE day1 day1 INT DEFAULT NULL, CHANGE day2 day2 INT DEFAULT NULL, CHANGE day3 day3 INT DEFAULT NULL, CHANGE day4 day4 INT DEFAULT NULL, CHANGE day5 day5 INT DEFAULT NULL, CHANGE day6 day6 INT DEFAULT NULL, CHANGE day7 day7 INT DEFAULT NULL, CHANGE day8 day8 INT DEFAULT NULL, CHANGE day9 day9 INT DEFAULT NULL, CHANGE day10 day10 INT DEFAULT NULL, CHANGE day11 day11 INT DEFAULT NULL, CHANGE day12 day12 INT DEFAULT NULL, CHANGE day13 day13 INT DEFAULT NULL');
        $this->addSql('ALTER TABLE info_client CHANGE client_id client_id INT DEFAULT NULL, CHANGE situation_famil_id situation_famil_id INT DEFAULT NULL, CHANGE age_client_id age_client_id INT DEFAULT NULL, CHANGE nbr_enfant_id nbr_enfant_id INT DEFAULT NULL, CHANGE type_client_new_id type_client_new_id INT DEFAULT NULL, CHANGE nom nom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE telephone telephone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE install_presentoire_jti CHANGE presentoire_id presentoire_id INT DEFAULT NULL, CHANGE is_installation is_installation TINYINT(1) DEFAULT \'NULL\', CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE list_install_pdv CHANGE install_day install_day VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE merch CHANGE region_id region_id INT DEFAULT NULL, CHANGE path_image path_image VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE image_name image_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE roles roles LONGTEXT DEFAULT NULL COLLATE utf8mb4_bin');
        $this->addSql('ALTER TABLE new_install_pdv CHANGE code_client code_client INT DEFAULT NULL, CHANGE licence licence VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE adress adress VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE titulairenom titulairenom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE titulairetel titulairetel VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE gerantnom gerantnom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE geranttel geranttel VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE operateurnom operateurnom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE operateurtel operateurtel VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE cin cin VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE code_postal code_postal VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE comment comment VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE comment_plv comment_plv VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE routings routings LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE plv plv LONGTEXT DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE new_install_pdv_comments CHANGE merch_status_comment merch_status_comment INT DEFAULT NULL, CHANGE modified_image modified_image VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE one_planning CHANGE date date DATETIME DEFAULT \'NULL\', CHANGE a a INT DEFAULT NULL, CHANGE am am INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pdv_ppsom CHANGE ppsom ppsom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE pdv_presentoire CHANGE image_id image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pdv_shop CHANGE image_id image_id INT DEFAULT NULL, CHANGE shop shop VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE pdv_tposm CHANGE image_id image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photos CHANGE perso_id perso_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plv_temporaire CHANGE quantiter_type_plv_id quantiter_type_plv_id INT DEFAULT NULL, CHANGE is_temporaire is_temporaire TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE praisontoir_maison_de_maire CHANGE maison_de_maire maison_de_maire VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE presence_ppsom_jti CHANGE is_present is_present TINYINT(1) DEFAULT \'NULL\', CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE presence_presentoire_jti CHANGE pdv_presentoire_id pdv_presentoire_id INT DEFAULT NULL, CHANGE is_present is_present TINYINT(1) DEFAULT \'NULL\', CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE presence_presentoire_not_jti CHANGE is_present is_present TINYINT(1) DEFAULT \'NULL\', CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE presence_shop_jti CHANGE is_present is_present TINYINT(1) DEFAULT \'NULL\', CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit CHANGE typeproduit_id typeproduit_id INT DEFAULT NULL, CHANGE file_id file_id INT DEFAULT NULL, CHANGE stoke stoke INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quantiter_type_plv CHANGE quantiter quantiter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE raison_presontoire CHANGE raison raison VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE rapport_global CHANGE rapport_pdv_id rapport_pdv_id INT DEFAULT NULL, CHANGE rapport_pposm_id rapport_pposm_id INT DEFAULT NULL, CHANGE rapport_tposm_id rapport_tposm_id INT DEFAULT NULL, CHANGE rapport_tlp_id rapport_tlp_id INT DEFAULT NULL, CHANGE merch_id merch_id INT DEFAULT NULL, CHANGE date_rappoort date_rappoort DATETIME DEFAULT \'NULL\', CHANGE durre durre VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE rapport_maintenance CHANGE rapport_global_id rapport_global_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_marketing CHANGE type_de_compagnie_id type_de_compagnie_id INT DEFAULT NULL, CHANGE nouvel_equipment_id nouvel_equipment_id INT DEFAULT NULL, CHANGE rapport_global_id rapport_global_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_pposm CHANGE client_id client_id INT DEFAULT NULL, CHANGE merch_id merch_id INT DEFAULT NULL, CHANGE install_presentoire_jti_id install_presentoire_jti_id INT DEFAULT NULL, CHANGE des_install_presentoire_jti_id des_install_presentoire_jti_id INT DEFAULT NULL, CHANGE presence_presentoire_jti_id presence_presentoire_jti_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_produit CHANGE rapport_global_id rapport_global_id INT DEFAULT NULL, CHANGE is_veder is_veder TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE rapport_tposm CHANGE presence_nbr_article_id presence_nbr_article_id INT DEFAULT NULL, CHANGE installation_nbr_id installation_nbr_id INT DEFAULT NULL, CHANGE instalation_raison_id instalation_raison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE routing CHANGE zone_id zone_id INT DEFAULT NULL, CHANGE information information VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE nbrs_pdv nbrs_pdv INT DEFAULT NULL, CHANGE merch merch VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE situation_familialle CHANGE sitation sitation VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE stoke_sheet CHANGE stoke_sheet stoke_sheet VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE survey CHANGE cycle cycle INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_client CHANGE type type VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE type_plv CHANGE type type VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE user_name_admin user_name_admin VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE roles roles LONGTEXT DEFAULT NULL COLLATE utf8mb4_bin');
    }
}
