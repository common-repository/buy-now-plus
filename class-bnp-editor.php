<?php
if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');}

class BNP_Editor {
  public function __construct() {
    // TinyMCE
    add_action( 'admin_init', array( $this, 'editor_buttons' ) );

    // Ajax
    add_action( 'wp_ajax_bnp_query_buttons', array( $this, 'ajax_query_buttons') );
  }

  // TinyMCE
  public function editor_buttons() {
    if ( $this->has_api_key() ) {
      add_filter( 'mce_external_plugins', array( $this, 'add_editor_buttons' ) );
      add_filter( 'mce_buttons', array( $this, 'register_editor_buttons' ) );
    }
  }

  public function add_editor_buttons( $plugin_array ) {
    $plugin_array['buynowplus'] = plugins_url( 'js/buynowplus.js', __FILE__ );
    return $plugin_array;
  }

  public function register_editor_buttons( $buttons ) {
    $buttons[] = 'buynow';
    return $buttons;
  }

  // Use ajax to query the server endpoint for buttons
  public function ajax_query_buttons() {
    $path = '/api/buttons';

    $options = get_option( 'buynowplus_settings' );
    $apikey = $options['apikey'];

    $url = BNP_ROOT_URL . $path;
    $args = array(
      'headers' => array(
        'Content-type' => 'application/json',
        'Authorization' => 'Bearer ' . $apikey
      )
    );

    $response = wp_remote_get( $url, $args );
    $body = wp_remote_retrieve_body( $response );
    $response_code = wp_remote_retrieve_response_code( $response );

    if ( $response_code !== 200 || ! isset( $body ) ) {
      $message = 'Error accessing server: ' . $response_code;
      wp_send_json_error( $message );
    } else {
      wp_send_json_success( $body );
    }
  }

  // Private functions

  private function has_api_key() {
    $option = get_option( 'buynowplus_settings' );

    return !empty($option);
  }

}

$bnp_editor = new BNP_Editor();
