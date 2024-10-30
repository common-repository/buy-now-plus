<?php
if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');}

class BNP_Settings {
  public function __construct() {
    add_action( 'admin_menu', array( $this,'admin_menu' ) );
    add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
  }

  public function admin_menu() {
    add_options_page( __('Buy Now Plus Options', 'buy-now-plus'), __('Buy Now Plus', 'buy-now-plus'), 'manage_options', BNP_SLUG, array( $this, 'admin_options_page' ) );

    register_setting( 'buynowplus_settings_security', 'buynowplus_settings', array( $this, 'validate_apikey') );
    add_settings_section( 'security_section', 'Buy Now Plus Account', array( $this, 'security_section_callback' ), 'buynowplus_security' );
    add_settings_field( 'apikey', 'API Key', array( $this, 'setting_apikey_callback' ), 'buynowplus_security', 'security_section', array( 'label_for' => 'buynowplus_settings' ) );
  }

  public function admin_options_page() {
    require(BNP_VIEW_DIR . 'settings-template.php');
  }

  public function admin_enqueue_scripts() {
    wp_register_style( 'buynowplus', plugins_url( 'css/buynowplus.css', __FILE__ ) );
    wp_enqueue_style( 'buynowplus' );
  }

  public function setting_apikey_callback() {
    $options = get_option('buynowplus_settings');
    echo "<input type='text' class='regular-text' name='buynowplus_settings[apikey]' value='{$options['apikey']}' />";
  }

  public function security_section_callback() {
    echo '<p>Sign in to your <a href="https://buynowplus.com">Buy Now Plus</a> account to find your API key. Once logged in go to Account > Settings. Copy and paste your "API Key" in to the form below.</p>';
  }

  public function validate_apikey( $input ) {
    $output = get_option( 'buynowplus_settings' );

    if ( !empty( $output['apikey'] ) && $output['apikey'] == $input['apikey'] ) {

      // Assume its already been set so don't hit the server again

      add_settings_error( 'buynowplus_settings', 'valid-apikey', 'Your API key has already been saved.', 'updated' );
    } else {
      $path = '/api/verify/';
      $apikey = $input['apikey'];

      // Ask the server if key is valid

      $url = BNP_ROOT_URL . $path;
      $args = array(
        'headers' => array(
          "Content-type" => "application/json",
          'Authorization' => 'Bearer ' . $apikey
        )
      );

      $response = wp_remote_get( $url, $args );
      $response_code = wp_remote_retrieve_response_code( $response );

      if ( $response_code == '200' ) {
        $output['apikey'] = $input['apikey'];
      } else {
        add_settings_error( 'buynowplus_settings', 'valid-apikey', 'Invalid API key' );
      }
    }

    return $output;
  }
}

$bnp_settings = new BNP_Settings;
