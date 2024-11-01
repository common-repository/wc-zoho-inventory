<?php

namespace BitPress\BIT_WC_ZOHO_INVENTORY\Admin;

/**
 * The admin menu and page handler class
 */
class Admin_Bar
{
    public function register()
    {
        add_action('init', [$this, 'register_post_type']);
        add_action('admin_menu', [$this, 'register_admin_menu']);
        /*  */
    }

    /**
     * Register the admin menu
     *
     * @return void
     */
    public function register_admin_menu()
    {
        global $submenu;

        $capability = apply_filters('bit_wc_zoho_inventory_form_access_capability', 'manage_options');

        $hook = add_menu_page(__('Inventory for WooCommerce in Zoho - The Best Plugin for Integrating with Zoho Inventory with WooCommerce', 'Inventory for WooCommerce in Zoho'), 'Inventory for WooCommerce in Zoho', $capability, 'bit_wc_zoho_inventory', [$this, 'table_home_page'], 'data:image/svg+xml;base64,' . base64_encode('<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="256" height="256" viewBox="0 0 256 256"><defs><style>.cls-1{fill:#fff;}</style></defs><rect class="cls-1" width="256" height="256" rx="40"/><path d="M101.2,170.61v9.48a3.91,3.91,0,0,1-3.9,3.9H25a3.91,3.91,0,0,1-3.9-3.9v-8.44a3.9,3.9,0,0,1,.9-2.49L66.06,116a3.9,3.9,0,0,0-3-6.39h-37a3.89,3.89,0,0,1-3.9-3.9V96.28a3.89,3.89,0,0,1,3.9-3.9H95.33a3.89,3.89,0,0,1,3.9,3.9v8.44a3.89,3.89,0,0,1-.89,2.48L54.39,160.33a3.9,3.9,0,0,0,3,6.38H97.3A3.91,3.91,0,0,1,101.2,170.61Z"/><path d="M234.7,97.49,207.28,181.3a3.9,3.9,0,0,1-3.7,2.69H186.47a3.9,3.9,0,0,1-3.71-2.7L163.48,122l-19.92,59.37a3.89,3.89,0,0,1-3.69,2.66h-17a3.89,3.89,0,0,1-3.7-2.68L91.61,97.49a3.89,3.89,0,0,1,3.7-5.11h13.76a3.88,3.88,0,0,1,3.71,2.71l19.81,61.68L153.3,95A3.89,3.89,0,0,1,157,92.38h14a3.9,3.9,0,0,1,3.71,2.7l20.07,62.21,20.45-62.23a3.89,3.89,0,0,1,3.7-2.68H231A3.89,3.89,0,0,1,234.7,97.49Z"/><rect x="92.19" y="58.01" width="20.32" height="16.74" rx="5"/></svg>'), 56);

        add_action('load-' . $hook, [$this, 'load_assets']);
    }

    /**
     * Load the asset libraries
     *
     * @return void
     */
    public function load_assets()
    {
        /*  require_once dirname( __FILE__ ) . '/class-form-builder-assets.php';
        new BIT_WC_ZOHO_INVENTORY_Form_Builder_Assets(); */
    }

    /**
     * The contact form page handler
     *
     * @return void
     */
    public function table_home_page()
    {
        // require_once BIT_WC_ZOHO_INVENTORY_PLUGIN_DIR_PATH . '/views/view-root.php';
        echo '<div id="bit-wi-root"></div>';

        /* echo plugin_basename( BIT_WC_ZOHO_INVENTORY_PLUGIN_MAIN_FILE );
      $query = new WP_Query();
      $forms = $query->get_posts();
      var_dump($forms); */
        global $wp_rewrite;
        $api = [
            'base'      => get_rest_url() . 'bitwcinventoryzoho/v1',
            'separator' => $wp_rewrite->permalink_structure ? '?' : '&'
        ];
        $parsed_url = parse_url(get_admin_url());
        //   echo get_admin_url();
        $base_apth_admin = str_replace($parsed_url['scheme'] . '://' . $parsed_url['host'], null, get_admin_url());
        wp_enqueue_script('bit_wc_zoho_inventory-admin-script', BIT_WC_ZOHO_INVENTORY_ASSET_URI . '/js/index.js');
        $bit_wc_zoho_inventory = apply_filters('bit_wc_zoho_inventory_localized_script', [
            'nonce'           => wp_create_nonce('bit_wc_zoho_inventory'),
            'confirm'         => __('Are you sure?', 'bit_wc_zoho_inventory'),
            'isPro'           => false,
            'routeComponents' => ['default' => null],
            'mixins'          => ['default' => null],
            'assetsURL'       => BIT_WC_ZOHO_INVENTORY_ASSET_URI . '/js/',
            'baseURL'         => $base_apth_admin . 'admin.php?page=bit_wc_zoho_inventory#/',
            'ajaxURL'         => admin_url('admin-ajax.php'),
            'api'             => $api,
        ]);
        // $checkoutFields = (new WC_Checkout)->get_checkout_fields();
        // $checkoutFields = WC()->checkout()->get_checkout_fields();
        // $bit_wc_zoho_inventory['checkoutFields'] = (new WC_Checkout)->get_checkout_fields();
        wp_localize_script('bit_wc_zoho_inventory-admin-script', 'bit_wc_zoho_inventory', $bit_wc_zoho_inventory);
    }

    /**
     * Admin footer text.
     *
     * Fired by `admin_footer_text` filter.
     *
     * @since 1.3.5
     *
     * @param string $footer_text The content that will be printed.
     *
     * @return string The content that will be printed.
     **/
    public function admin_footer_text($footer_text)
    {
        $current_screen = get_current_screen();
        $is_bit_wc_zoho_inventorys_screen = ($current_screen && false !== strpos($current_screen->id, 'bit_wc_zoho_inventory'));

        if ($is_bit_wc_zoho_inventorys_screen) {
            $footer_text = sprintf(
                __('If you like %1$s please leave us a %2$s rating. A huge thank you from %3$s in advance!', 'bit_wc_zoho_inventory'),
                '<strong>' . __('bit_wc_zoho_inventory', 'bit_wc_zoho_inventory') . '</strong>',
                '<a href="https://wordpress.org/support/plugin/bit_wc_zoho_inventory/reviews/" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a>',
                '<strong>Bit Press</strong>'
            );
        }

        return $footer_text;
    }
}
