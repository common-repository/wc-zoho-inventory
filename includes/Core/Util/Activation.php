<?php

namespace BitPress\BIT_WC_ZOHO_INVENTORY\Core\Util;

/**
 * Class handling plugin activation.
 *
 * @since 1.0.0
 * @access private
 * @ignore
 */
final class Activation
{
    public function activate()
    {
        add_action(
            'bit_wc_zoho_inventory_activation',
            function ($network_wide) {
                // Set activation flag.
                $this->install();
            }
        );
    }
    //frm install 
    public function install()
    {

        $this->create_tables();

        $installed = get_option('bit_wc_zoho_inventory_installed');

        if (!$installed) {
            update_option('bit_wc_zoho_inventory_installed', time());
        }

        set_transient('bit_wc_zoho_inventory_activation_redirect', true, 30);
        set_transient('bit_wc_zoho_inventory_prevent_tracker_notice', true, DAY_IN_SECONDS * 7); // don't wanna show tracking notice in first 7 days
        update_option('bit_wc_zoho_inventory_version', BIT_WC_ZOHO_INVENTORY_VERSION);
    }

    /**
     * Create the table schema
     *
     * @return void
     */
    public function create_tables()
    {
        global $wpdb;

        $collate = '';

        if ($wpdb->has_cap('collation')) {
            if (!empty($wpdb->charset)) {
                $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
            }

            if (!empty($wpdb->collate)) {
                $collate .= " COLLATE $wpdb->collate";
            }
        }

        $table_schema = array(
            "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}bit_wc_zoho_inventory_integration` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `integration_details` TEXT DEFAULT NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) $collate;",
            "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}bit_wc_zoho_inventory_log` (
                `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
                `order_id` BIGINT(20) unsigned NOT NULL,
                `api_type` VARCHAR(20) DEFAULT NULL,
                `response_type` VARCHAR(20) DEFAULT NULL,
                `response_obj` TEXT DEFAULT NULL,
                `generated_at` VARCHAR(20) DEFAULT NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) $collate;"
        );

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        foreach ($table_schema as $table) {
            dbDelta($table);
        }
    }
}
