<?php
// Register the settings page
function my_plugin_settings_page() {
    // Register setting
    register_setting( 'whatsapp-orders-woocommerce-settings', 'wow_phone' );

    // Add options page
    add_options_page(
        'WhatsApp Orders WooCommerce Settings',
        'WhatsApp Orders WooCommerce',
        'manage_options',
        'whatsapp-orders-woocommerce-settings',
        'my_plugin_render_settings'
    );
}
add_action('admin_menu', 'my_plugin_settings_page');

// Render the settings page
function my_plugin_render_settings() {
    ?>
    <div class="wrap">
        <h1>WhatsApp Orders WooCommerce Settings</h1>
        <form method="post" action="options.php">
            <?php
            // Output security fields for the registered setting
            settings_fields('whatsapp-orders-woocommerce-settings');
            // Output setting sections and their fields
            do_settings_sections('whatsapp-orders-woocommerce-settings');
            ?>
            <label for="wow_phone">Teléfono Celular para WhatsApp:</label>
            <input type="text" id="wow_phone" name="wow_phone" value="<?php echo esc_attr(get_option('wow_phone')); ?>">
            <?php
            // Output a submit button
            submit_button('Guardar cambios');
            ?>
        </form>
    </div>
    <?php
}
