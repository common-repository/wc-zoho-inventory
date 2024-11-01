<?php

namespace BitPress\BIT_WC_ZOHO_INVENTORY\API\Routes;

use WP_REST_Controller;
use WP_REST_Server;
use BitPress\BIT_WC_ZOHO_INVENTORY\API\Controllers\AuthorizationController;


class Routes extends WP_REST_Controller
{
  function __construct()
  {
    $this->namespace = 'bitwcinventoryzoho';
    $this->rest_base = 'v1';
    $this->authorizationController = new AuthorizationController();
  }

  public function register_routes()
  {

    register_rest_route(
      $this->namespace,
      $this->rest_base . '/authoraization/',
      [
        [
          'methods'   => WP_REST_Server::READABLE,
          'callback'  => [$this->authorizationController, 'Authorization'],
          'permission_callback' => '__return_true'
        ],
        'schema' => [$this, 'get_item_schema']

      ]
    );
  }

  public function get_items_permissions_check($request)
  {
    $integrateData = get_option('bitformpro_integrate_key_data');
    $header = $request->get_header('Bitform-Api-Key');
    $api_key =  get_option('bitform_secret_api_key');
    $error = '';

    if (empty($header)) {

      $error = ['message' => 'Api Key is required to access this resource'];
    } else if (!is_array($integrateData) && !isset($integrateData['key'])) {

      $error = 'Bitform pro License Key is Invalid';
    } else if ($request->get_header('Bitform-Api-Key') != $api_key || $api_key == null) {

      $error = 'Invalid API key';
    }

    if (!empty($error)) {
      return wp_send_json_error(['message' => $error], 401);
    }

    return true;
  }
}
