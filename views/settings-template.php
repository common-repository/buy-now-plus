<?php if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');} ?>

<div class="wrap">

  <form id="bnp-settings" action="options.php" method="post">
    <?php settings_fields('buynowplus_settings_security'); ?>
    <?php do_settings_sections('buynowplus_security'); ?>

    <div>
      <input type="submit" class="button-primary" value="<?php _e('Connect'); ?>" />
    </div>
  </form>
</div>
