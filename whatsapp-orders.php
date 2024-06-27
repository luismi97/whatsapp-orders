<?php
/**
* Plugin Name: Whatsapp Orders For Woocommerce
* Plugin URI: https://www.techbridgecr.com/
* Description: Whatsapp Ordering with Woocommerce
* Version: 0.1
* Author: Luis Miguel Molina Rodriguez
* Author URI: https://www.techbridgecr.com/
**/

// Load logic
require __DIR__ . '/woocommerce-cart-hook.php';
require __DIR__ . '/settings.php';

// Register settings link
function wow_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=whatsapp-orders-woocommerce-settings">Ajustes</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wow_settings_link');