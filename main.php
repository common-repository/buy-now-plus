<?php
/*
Plugin Name: Buy Now Plus
Plugin URI: https://buynowplus.com/
Description: The official connector plugin for BuyNowPlus.com
Version: 1.0.1
Author: Caseproof, LLC
Author URI: http://caseproof.com/
Text Domain: buy-now-plus
Copyright: 2004-2019, Caseproof, LLC
*/

if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');}

$bnp_url_protocol = (is_ssl())?'https':'http'; // Make all of our URLS protocol agnostic

define( 'BNP_SLUG'        , 'buy-now-plus' );
define( 'BNP_PLUGIN_NAME' , 'Buy Now Plus');

define( 'BNP_PLUGIN_DIR'  , plugin_dir_path( __FILE__ ) );
define( 'BNP_PLUGIN_URL'  , preg_replace( '/^https?:/', "{$bnp_url_protocol}:", plugins_url( '/' . BNP_SLUG ) ) );

define( 'BNP_FILE'        , BNP_PLUGIN_DIR . 'main.php' );

if(!defined('BNP_ROOT_URL')) {
  define( 'BNP_ROOT_URL'    , 'https://buynowplus.com');
}

define( 'BNP_VIEW_DIR'    , BNP_PLUGIN_DIR . 'views' . '/' );
define( 'BNP_JS_DIR'      , BNP_ROOT_URL . 'js' . '/' );


require_once( BNP_PLUGIN_DIR . 'class-bnp-settings.php' );
require_once( BNP_PLUGIN_DIR . 'class-bnp-buttons.php' );
require_once( BNP_PLUGIN_DIR . 'class-bnp-editor.php' );
