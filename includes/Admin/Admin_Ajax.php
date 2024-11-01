<?php

namespace BitPress\BIT_WC_ZOHO_INVENTORY\Admin;

use BitPress\BIT_WC_ZOHO_INVENTORY\Plugin;
use BitPress\BIT_WC_ZOHO_INVENTORY\Core\Util\HttpHelper;
use WC_Checkout;

class Admin_Ajax
{
    public $wpdb;
    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public function register()
    {
        add_action('wp_ajax_bit_wc_generate_token', [$this, 'generateTokens']);
        add_action('wp_ajax_bit_get_log_data', [$this, 'getLogData']);
        add_action('wp_ajax_bit_get_integration_data', [$this, 'getIntegData']);
        add_action('wp_ajax_bit_add_integration_data', [$this, 'addIntegData']);
        add_action('wp_ajax_bit_save_integration_data', [$this, 'saveIntegData']);
        add_action('wp_ajax_bit_import_order_data', [$this, 'importOrderData']);
        add_action('wp_ajax_bit_wc_refresh_organizations', [$this, 'refreshOrganizationsAjaxHelper']);
        add_action('wp_ajax_bit_wc_refresh_fields', [$this, 'refreshFields']);
    }

    public function getLogData()
    {
        if (isset($_REQUEST['_ajax_nonce']) && wp_verify_nonce(sanitize_text_field($_REQUEST['_ajax_nonce']), 'bit_wc_zoho_inventory')) {
            $inputJSON = file_get_contents('php://input');
            $requestsParams = json_decode($inputJSON);
            $query = "SELECT * FROM {$this->wpdb->prefix}bit_wc_zoho_inventory_log ORDER BY {$requestsParams->sortBy->sortField} ";
            if (!empty($requestsParams->sortBy->orderType)) {
                $query .= $requestsParams->sortBy->orderType;
            } else {
                $query .= 'DESC';
            }
            $query .= " LIMIT {$requestsParams->offset},10";
            $response['logs'] = $this->wpdb->get_results($query);

            // get count
            $response['total_log'] = $this->wpdb->get_row("SELECT COUNT(id) as count FROM {$this->wpdb->prefix}bit_wc_zoho_inventory_log");
            wp_send_json_success($response, 200);
        }
    }

    private function woocommerce_get_order_statuses()
    {
        if (!function_exists('wc_get_order_statuses')) {
            require_once dirname(WC_PLUGIN_FILE) . '/includes/wc-order-functions.php';
        }

        if (function_exists('wc_get_order_statuses')) {
            return wc_get_order_statuses();
        }

        return (object) [];
    }

    public function getIntegData()
    {
        if (isset($_REQUEST['_ajax_nonce']) && wp_verify_nonce(sanitize_text_field($_REQUEST['_ajax_nonce']), 'bit_wc_zoho_inventory')) {
            $response['integ'] = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}bit_wc_zoho_inventory_integration LIMIT 1");
            $response['wc_status'] = $this->woocommerce_get_order_statuses();
            wp_send_json_success($response, 200);
        }
    }

    public function addIntegData()
    {
        if (isset($_REQUEST['_ajax_nonce']) && wp_verify_nonce(sanitize_text_field($_REQUEST['_ajax_nonce']), 'bit_wc_zoho_inventory')) {
            $inputJSON = file_get_contents('php://input');
            $requestsParams = json_decode($inputJSON);
            unset($requestsParams->wcInventoryConf->newInteg);
            $integration_details = wp_json_encode($requestsParams->wcInventoryConf);
            $result = $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->wpdb->prefix}bit_wc_zoho_inventory_integration(integration_details) VALUE(%s)", $integration_details));
            if ($result) {
                wp_send_json_success('Integration Saved Successfully', 200);
            } else {
                wp_send_json_error('Integration Create failed!', 400);
            }
        }
    }

    public function saveIntegData()
    {
        if (isset($_REQUEST['_ajax_nonce']) && wp_verify_nonce(sanitize_text_field($_REQUEST['_ajax_nonce']), 'bit_wc_zoho_inventory')) {
            $inputJSON = file_get_contents('php://input');
            $requestsParams = json_decode($inputJSON);
            $integration_details = wp_json_encode($requestsParams->wcInventoryConf);
            $integration_details = str_replace("'", "\'", $integration_details);
            $idSql = "SELECT id FROM {$this->wpdb->prefix}bit_wc_zoho_inventory_integration ORDER BY id DESC LIMIT 1";
            $id = $this->wpdb->get_results($idSql)[0]->id;

            $result = $this->wpdb->query("UPDATE {$this->wpdb->prefix}bit_wc_zoho_inventory_integration SET integration_details = '$integration_details' WHERE id = $id ");

            if ($result) {
                wp_send_json_success('Integration Updated Successfully', 200);
            } else {
                wp_send_json_error('Integration Update failed!', 400);
            }
        }
    }

    private function woocommerce_get_orders($args)
    {
        if (!function_exists('wc_get_orders')) {
            require_once dirname(WC_PLUGIN_FILE) . '/includes/wc-order-functions.php';
        }

        if (function_exists('wc_get_orders')) {
            return wc_get_orders($args);
        }

        return [];
    }

    public function importOrderData()
    {
        if (isset($_REQUEST['_ajax_nonce']) && wp_verify_nonce(sanitize_text_field($_REQUEST['_ajax_nonce']), 'bit_wc_zoho_inventory')) {
            $inputJSON = file_get_contents('php://input');
            $requestsParams = json_decode($inputJSON)->importDataOptions;
            $args = [
                'return'          => 'ids',
                'order'           => 'ASC',
                'limit'           => 9999
            ];
            if (isset($requestsParams->start_date) && !empty($requestsParams->start_date)) {
                $date_created = $requestsParams->start_date;
                if (isset($requestsParams->end_date) && !empty($requestsParams->end_date)) {
                    $date_created .= '...' . $requestsParams->end_date;
                }
                $args['date_created'] = $date_created;
            }
            if (isset($requestsParams->status) && !empty($requestsParams->status)) {
                $args['status'] = explode(',', $requestsParams->status);
            }
            $orders = $this->woocommerce_get_orders($args);
            $pluginInstance = new Plugin();
            foreach ($orders as $order_id) {
                $pluginInstance->executeIntegration($order_id, $requestsParams->importType);
            }
            wp_send_json_success('Orders Imported to Zoho Inventory Successfully', 200);
        }
    }

    public static function generateTokens()
    {
        if (isset($_REQUEST['_ajax_nonce']) && wp_verify_nonce(sanitize_text_field($_REQUEST['_ajax_nonce']), 'bit_wc_zoho_inventory')) {
            $inputJSON = file_get_contents('php://input');
            $requestsParams = json_decode($inputJSON);
            if (
                empty($requestsParams->{'accounts-server'})
                || empty($requestsParams->dataCenter)
                || empty($requestsParams->clientId)
                || empty($requestsParams->clientSecret)
                || empty($requestsParams->redirectURI)
                || empty($requestsParams->code)
            ) {
                wp_send_json_error(
                    __(
                        'Requested parameter is empty',
                        'bit_wc_zoho_inventory'
                    ),
                    400
                );
            }
            $apiEndpoint = \urldecode($requestsParams->{'accounts-server'}) . '/oauth/v2/token';
            $requestParams = [
                'grant_type'    => 'authorization_code',
                'client_id'     => $requestsParams->clientId,
                'client_secret' => $requestsParams->clientSecret,
                'redirect_uri'  => \urldecode($requestsParams->redirectURI),
                'code'          => $requestsParams->code
            ];
            $apiResponse = HttpHelper::post($apiEndpoint, $requestParams);
            if (is_wp_error($apiResponse) || !empty($apiResponse->error)) {
                wp_send_json_error(
                    empty($apiResponse->error) ? 'Unknown' : $apiResponse->error,
                    400
                );
            }
            $apiResponse->generates_on = \time();
            wp_send_json_success($apiResponse, 200);
        } else {
            wp_send_json_error(
                __(
                    'Token expired',
                    'bit_wc_zoho_inventory'
                ),
                401
            );
        }
    }

    public static function refreshAccessToken($apiData)
    {
        if (
            empty($apiData->dataCenter)
            || empty($apiData->clientId)
            || empty($apiData->clientSecret)
            || empty($apiData->tokenDetails)
        ) {
            return false;
        }
        $tokenDetails = $apiData->tokenDetails;

        $dataCenter = $apiData->dataCenter;
        $apiEndpoint = "https://accounts.zoho.{$dataCenter}/oauth/v2/token";
        $requestParams = [
            'grant_type'    => 'refresh_token',
            'client_id'     => $apiData->clientId,
            'client_secret' => $apiData->clientSecret,
            'refresh_token' => $tokenDetails->refresh_token,
        ];

        $apiResponse = HttpHelper::post($apiEndpoint, $requestParams);
        if (is_wp_error($apiResponse) || !empty($apiResponse->error)) {
            return false;
        }
        $tokenDetails->generates_on = \time();
        $tokenDetails->access_token = $apiResponse->access_token;
        return $tokenDetails;
    }

    public static function refreshOrganizationsAjaxHelper()
    {
        if (isset($_REQUEST['_ajax_nonce']) && wp_verify_nonce(sanitize_text_field($_REQUEST['_ajax_nonce']), 'bit_wc_zoho_inventory')) {
            $inputJSON = file_get_contents('php://input');
            $queryParams = json_decode($inputJSON);
            if (
                empty($queryParams->tokenDetails)
                || empty($queryParams->dataCenter)
                || empty($queryParams->clientId)
                || empty($queryParams->clientSecret)
            ) {
                wp_send_json_error(
                    __(
                        'Requested parameter is empty',
                        'bit_wc_zoho_inventory'
                    ),
                    400
                );
            }
            $response = [];
            if ((intval($queryParams->tokenDetails->generates_on) + (55 * 60)) < time()) {
                $response['tokenDetails'] = Admin_Ajax::refreshAccessToken($queryParams);
            }

            $organizationsMetaApiEndpoint = "https://www.zohoapis.{$queryParams->dataCenter}/inventory/v1/organizations";
            $authorizationHeader['Authorization'] = "Zoho-oauthtoken {$queryParams->tokenDetails->access_token}";

            $modulesMetaResponse = HttpHelper::get($organizationsMetaApiEndpoint, null, $authorizationHeader);
            if (!is_wp_error($modulesMetaResponse) && (empty($modulesMetaResponse->status) || (!empty($modulesMetaResponse->status) && $modulesMetaResponse->status !== 'error'))) {
                $retriveModuleData = $modulesMetaResponse->organizations;

                $allModules = [];
                foreach ($retriveModuleData as $key => $value) {
                    $allModules[$value->name] = (object) [
                        'orgId'   => $value->organization_id,
                        'orgName' => $value->name,
                    ];
                }
                uksort($allModules, 'strnatcasecmp');
                $response['organizations'] = $allModules;
            } else {
                wp_send_json_error(
                    empty($modulesMetaResponse->error) ? 'Unknown' : $modulesMetaResponse->error,
                    400
                );
            }
            wp_send_json_success($response, 200);
        } else {
            wp_send_json_error(
                __(
                    'Token expired',
                    'bit_wc_zoho_inventory'
                ),
                401
            );
        }
    }

    public static function refreshFields()
    {
        global $wpdb;

        if (isset($_REQUEST['_ajax_nonce']) && wp_verify_nonce(sanitize_text_field($_REQUEST['_ajax_nonce']), 'bit_wc_zoho_inventory')) {
            $inputJSON = file_get_contents('php://input');
            $queryParams = json_decode($inputJSON);
            if (
                empty($queryParams->tokenDetails)
                || empty($queryParams->dataCenter)
                || empty($queryParams->clientId)
                || empty($queryParams->clientSecret)
                || empty($queryParams->orgId)
            ) {
                wp_send_json_error(
                    __(
                        'Requested parameter is empty',
                        'bit_wc_zoho_inventory'
                    ),
                    400
                );
            }
            $response = [];
            if ((intval($queryParams->tokenDetails->generates_on) + (55 * 60)) < time()) {
                $response['tokenDetails'] = Admin_Ajax::refreshAccessToken($queryParams);
            }

            $wcCheckoutFields = (new WC_Checkout)->get_checkout_fields();
            if ($wcCheckoutFields) {
                uksort($wcCheckoutFields, 'strnatcasecmp');
                $wcCheckoutFields['shipping']['shipping_total'] = (object) [
                    'label' => 'Shipping Total'
                ];
                $response['wcCheckoutFields'] = $wcCheckoutFields;
            } else {
                wp_send_json_error('Unknown Error', 400);
            }

            $inventoryCustomerFields = [
                'Customer Name' => [
                    'apiName'      => 'contact_name',
                    'displayLabel' => 'Customer Name',
                    'required'     => true
                ],
                'First Name' => [
                    'apiName'      => 'first_name',
                    'displayLabel' => 'First Name',
                ],
                'Salutation' => [
                    'apiName'      => 'salutation',
                    'displayLabel' => 'Salutation',
                ],
                'Last Name' => [
                    'apiName'      => 'last_name',
                    'displayLabel' => 'Last Name',
                ],
                'Company Name' => [
                    'apiName'      => 'company_name',
                    'displayLabel' => 'Company Name'
                ],
                'Customer Email' => [
                    'apiName'      => 'email',
                    'displayLabel' => 'Customer Email'
                ],
                'Phone' => [
                    'apiName'      => 'phone',
                    'displayLabel' => 'Phone'
                ],
                'Mobile' => [
                    'apiName'      => 'mobile',
                    'displayLabel' => 'Mobile'
                ],
                'Designation' => [
                    'apiName'      => 'designation',
                    'displayLabel' => 'Designation'
                ],
                'Department' => [
                    'apiName'      => 'department',
                    'displayLabel' => 'Department'
                ],
                'Payment Terms' => [
                    'apiName'      => 'payment_terms',
                    'displayLabel' => 'Payment Terms'
                ],
                'Website' => [
                    'apiName'      => 'website',
                    'displayLabel' => 'Website'
                ],
                'Customer Type' => [
                    'apiName'      => 'contact_type',
                    'displayLabel' => 'Customer Type'
                ],
                'Billing Address Attention' => [
                    'apiName'      => 'billing_address_bit_attention',
                    'displayLabel' => 'Billing Address Attention'
                ],
                'Billing Address Street 1' => [
                    'apiName'      => 'billing_address_bit_address',
                    'displayLabel' => 'Billing Address Street 1'
                ],
                'Billing Address Street 2' => [
                    'apiName'      => 'billing_address_bit_street2',
                    'displayLabel' => 'Billing Address Street 2'
                ],
                'Billing Address City' => [
                    'apiName'      => 'billing_address_bit_city',
                    'displayLabel' => 'Billing Address City'
                ],
                'Billing Address State' => [
                    'apiName'      => 'billing_address_bit_state',
                    'displayLabel' => 'Billing Address State'
                ],
                'Billing Address Zip Code' => [
                    'apiName'      => 'billing_address_bit_zip',
                    'displayLabel' => 'Billing Address Zip Code'
                ],
                'Billing Address country' => [
                    'apiName'      => 'billing_address_bit_country',
                    'displayLabel' => 'Billing Address country'
                ],
                'Shipping Address Attention' => [
                    'apiName'      => 'shipping_address_bit_attention',
                    'displayLabel' => 'Shipping Address Attention'
                ],
                'Shipping Address Street 1' => [
                    'apiName'      => 'shipping_address_bit_address',
                    'displayLabel' => 'Shipping Address Street 1'
                ],
                'Shipping Address Street 2' => [
                    'apiName'      => 'shipping_address_bit_street2',
                    'displayLabel' => 'Shipping Address Street 2'
                ],
                'Shipping Address City' => [
                    'apiName'      => 'shipping_address_bit_city',
                    'displayLabel' => 'Shipping Address City'
                ],
                'Shipping Address State' => [
                    'apiName'      => 'shipping_address_bit_state',
                    'displayLabel' => 'Shipping Address State'
                ],
                'Shipping Address Zip Code' => [
                    'apiName'      => 'shipping_address_bit_zip',
                    'displayLabel' => 'Shipping Address Zip Code'
                ],
                'Shipping Address country' => [
                    'apiName'      => 'shipping_address_bit_country',
                    'displayLabel' => 'Shipping Address country'
                ],
                'Remarks' => [
                    'apiName'      => 'notes',
                    'displayLabel' => 'Remarks'
                ],
                'Language Code' => [
                    'apiName'      => 'language_code',
                    'displayLabel' => 'Language Code'
                ],
                'Vat & Reg No.' => [
                    'apiName'      => 'vat_reg_no',
                    'displayLabel' => 'Vat & Reg No.'
                ],
                'Country Code' => [
                    'apiName'      => 'country_code',
                    'displayLabel' => 'Country Code'
                ],
                'Vat Treatment' => [
                    'apiName'      => 'vat_treatment',
                    'displayLabel' => 'Vat Treatment'
                ],
                'Tax Treatment' => [
                    'apiName'      => 'tax_treatment',
                    'displayLabel' => 'Tax Treatment'
                ],
                'Facebook' => [
                    'apiName'      => 'facebook',
                    'displayLabel' => 'Facebook'
                ],
                'Twitter' => [
                    'apiName'      => 'twitter',
                    'displayLabel' => 'Twitter'
                ],

                'Avalara Exemption Certificate Number' => [
                    'apiName'      => 'avatax_exempt_no',
                    'displayLabel' => 'Avalara Exemption Certificate Number'
                ],
                'Avalara Tax Code' => [
                    'apiName'      => 'avatax_use_code',
                    'displayLabel' => 'Avalara Tax Code'
                ],
                'Tax Exemption ID' => [
                    'apiName'      => 'tax_exemption_id',
                    'displayLabel' => 'Tax Exemption ID'
                ],
                'Tax Authority ID' => [
                    'apiName'      => 'tax_authority_id',
                    'displayLabel' => 'Tax Authority ID'
                ],
                'Tax ID' => [
                    'apiName'      => 'tax_id',
                    'displayLabel' => 'Tax ID'
                ],
                'Is Taxable' => [
                    'apiName'      => 'is_taxable',
                    'displayLabel' => 'Is Taxable'
                ],
                'Place of Contact' => [
                    'apiName'      => 'place_of_contact',
                    'displayLabel' => 'Place of Contact'
                ],
                'GST identification number' => [
                    'apiName'      => 'gst_no',
                    'displayLabel' => 'GST identification number'
                ],
                'GST Treatment' => [
                    'apiName'      => 'gst_treatment',
                    'displayLabel' => 'GST Treatment'
                ],
                'Tax Authority Name' => [
                    'apiName'      => 'tax_authority_name',
                    'displayLabel' => 'Tax Authority Name'
                ],
                'Tax Exemption Code' => [
                    'apiName'      => 'tax_exemption_code',
                    'displayLabel' => 'Tam Exemption Code'
                ]
            ];

            $customFieldsContactApiEndpoint = "https://www.zohoapis.{$queryParams->dataCenter}/inventory/v1/settings/fields?entity=contact&organization_id={$queryParams->orgId}";
            $authorizationHeader['Authorization'] = "Zoho-oauthtoken {$queryParams->tokenDetails->access_token}";

            $customFieldsContactApiResponse = HttpHelper::get($customFieldsContactApiEndpoint, null, $authorizationHeader);

            if (isset($customFieldsContactApiResponse->fields) && count($customFieldsContactApiResponse->fields)) {
                foreach ($customFieldsContactApiResponse->fields as $cContactField) {
                    $inventoryCustomerFields[$cContactField->field_name_formatted] = [
                        'apiName'      => $cContactField->field_name,
                        'displayLabel' => $cContactField->field_name_formatted,
                        'required'     => $cContactField->is_mandatory
                    ];
                }
            }

            $required = [];

            foreach ($inventoryCustomerFields as $key => $field) {
                if ($inventoryCustomerFields[$key]['required']) {
                    array_push($required, $inventoryCustomerFields[$key]['apiName']);
                }
            }
            uksort($inventoryCustomerFields, 'strnatcasecmp');
            $response['inventoryCustomerFields'] = [
                'fields'   => $inventoryCustomerFields,
                'required' => $required
            ];

            $inventorySalesFields = [
                'Sales Order Date' => [
                    'apiName'      => 'date',
                    'displayLabel' => 'Sales Order Date'
                ],
                'Shipment Date' => [
                    'apiName'      => 'shipment_date',
                    'displayLabel' => 'Shipment Date'
                ],
                'Customer Notes' => [
                    'apiName'      => 'notes',
                    'displayLabel' => 'Customer Notes'
                ],
                'Terms & Conditions' => [
                    'apiName'      => 'terms',
                    'displayLabel' => 'Terms & Conditions'
                ],
                'Discount' => [
                    'apiName'      => 'discount',
                    'displayLabel' => 'Discount'
                ],
                'Is Discount Before Tax' => [
                    'apiName'      => 'is_discount_before_tax',
                    'displayLabel' => 'Is Discount Before Tax'
                ],
                'Discount Type' => [
                    'apiName'      => 'discount_type',
                    'displayLabel' => 'Discount Type'
                ],
                'Shipping Charge' => [
                    'apiName'      => 'shipping_charge',
                    'displayLabel' => 'Shipping Charge'
                ],
                'Delivery Method' => [
                    'apiName'      => 'delivery_method',
                    'displayLabel' => 'Delivery Method'
                ],
                'Adjustment' => [
                    'apiName'      => 'adjustment',
                    'displayLabel' => 'Adjustment'
                ],
                'Adjustment Description' => [
                    'apiName'      => 'adjustment_description',
                    'displayLabel' => 'Adjustment Description'
                ],
                'Is Inclusive Tax' => [
                    'apiName'      => 'is_inclusive_tax',
                    'displayLabel' => 'Is Inclusive Tax'
                ],
                'Exchange Rate' => [
                    'apiName'      => 'exchange_rate',
                    'displayLabel' => 'Exchange Rate'
                ],
                'Place Of Supply' => [
                    'apiName'      => 'place_of_supply',
                    'displayLabel' => 'Place Of Supply'
                ]
            ];

            $customFieldsSalesOrderApiEndpoint = "https://www.zohoapis.{$queryParams->dataCenter}/inventory/settings/fields?entity=salesorder&organization_id={$queryParams->orgId}";

            $customFieldsSalesOrderApiResponse = HttpHelper::get($customFieldsSalesOrderApiEndpoint, null, $authorizationHeader);

            if (isset($customFieldsSalesOrderApiResponse->fields) && count($customFieldsSalesOrderApiResponse->fields)) {
                foreach ($customFieldsSalesOrderApiResponse->fields as $cSalesOrderField) {
                    $inventorySalesFields[$cSalesOrderField->field_name_formatted] = [
                        'apiName'      => $cSalesOrderField->field_name,
                        'displayLabel' => $cSalesOrderField->field_name_formatted,
                        'required'     => $cSalesOrderField->is_mandatory
                    ];
                }
            }


            $required = [];
            foreach ($inventorySalesFields as $key => $field) {
                if ($inventorySalesFields[$key]['required']) {
                    array_push($required, $inventorySalesFields[$key]['apiName']);
                }
            }
            uksort($inventorySalesFields, 'strnatcasecmp');
            $response['inventorySalesFields'] = [
                'fields'   => $inventorySalesFields,
                'required' => $required
            ];
            wp_send_json_success($response, 200);
        } else {
            wp_send_json_error(
                __(
                    'Token expired',
                    'bit_wc_zoho_inventory'
                ),
                401
            );
        }
    }
}
