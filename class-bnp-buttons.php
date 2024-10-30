<?php
if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');}

class BNP_Buttons {
  public function __construct() {
    add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
    add_shortcode( 'buynowplus', array( $this, 'bnp_button_shortcode' ) );
  }

  // Load styles
  public function wp_enqueue_scripts() {
    wp_register_style( 'buynowplus', plugins_url( 'css/buynowplus.css', __FILE__ ) );
    wp_enqueue_style( 'buynowplus' );
  }

  // Converts the shortcode to html
  public function bnp_button_shortcode( $atts, $content='' ) {
    $atts = shortcode_atts(
      array(
        'button' => '',
        'title' => 'Buy Now',
        'url' => '',
        'class' => 'buy-now',
        'id' => '',
        'type' => 'link',
      ),
      $atts
    );

    if(empty($atts['id'])) {
      $atts['id'] = 'buy-now-' . $atts['button'] . '-' . uniqid();
    }

    extract($atts);

    $html = "<a id=\"{$id}\" class=\"{$class}\" href=\"{$url}\" title=\"{$title}\">{$content}</a>";
    return $html;
  }

}

$bnp_buttons = new BNP_Buttons();
