<?php

// Función para imprimir datos de forma legible
function print_pretty($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

// Función para construir y enviar el mensaje de WhatsApp
function build_whatsapp_message($order_id) {
    // Obtener el objeto de la orden
    $order = wc_get_order($order_id);

    // Inicializar el mensaje de la orden
    $order_msg = '';

    // Código para salto de línea en WhatsApp
    $break_line = "%0a";

    // Construir el mensaje de la orden
    $order_msg .= $order->get_shipping_first_name() . " ";
    $order_msg .= $order->get_shipping_last_name() . $break_line;
    $order_msg .= $order->get_shipping_address_1() . $break_line;
    $order_msg .= $order->get_shipping_address_2() . $break_line;

    // Aquí se puede personalizar el nombre del restaurante o categoría
    $order_msg .= "restaurant_name" . $break_line;

    // Iterar sobre los ítems de la orden
    foreach ($order->get_items() as $item_id => $item) {
        $product = $item->get_product();

        // Agregar cantidad y nombre del producto al mensaje
        $order_msg .= $item->get_quantity() . ". ";
        $order_msg .= $item->get_name() . " -> ₡";
        $order_msg .= $item->get_total() . $break_line;

        // Obtener la categoría del producto
        $categories = get_the_terms($product->get_id(), 'product_cat');
        if ($categories && !is_wp_error($categories)) {
            $category_name = "Local: " . $categories[0]->name;
            $order_msg = str_replace('restaurant_name', $category_name, $order_msg);
        }
    }

    // Agregar el total de la orden al mensaje
    $order_msg .= "TOTAL sin express: ₡" . $order->get_total() . $break_line;

    // Mensaje final de agradecimiento
    $order_msg .= "¡Gracias por su orden!";

    // Redirigir al enlace de WhatsApp con el mensaje generado
    redirect_to_whatsapp($order_msg);
}

// Hook para ejecutar la función al completarse una orden en WooCommerce
add_action('woocommerce_thankyou', 'build_whatsapp_message');

// Función para redirigir al enlace de WhatsApp
function redirect_to_whatsapp($order_msg) {
    // Obtener el número de teléfono desde la configuración del plugin
    $phone = esc_attr(get_option('wow_phone'));

    // Construir la URL con el número de teléfono y el mensaje
    $url = "https://api.whatsapp.com/send/?phone=" . $phone . '&text=' . rawurlencode($order_msg);

    // Redirigir al usuario al enlace de WhatsApp
    wp_redirect($url);
    exit;
}
