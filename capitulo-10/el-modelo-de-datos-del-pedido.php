$pedido = wc_get_order( $order_id );

// Datos del pedido
$total     = $pedido->get_total();
$subtotal  = $pedido->get_subtotal();
$estado    = $pedido->get_status();           // 'pending', 'processing', 'completed'...
$cliente   = $pedido->get_user_id();
$email     = $pedido->get_billing_email();
$fecha     = $pedido->get_date_created();

// Dirección de envío
$nombre    = $pedido->get_shipping_first_name() . ' ' . $pedido->get_shipping_last_name();
$direccion = $pedido->get_shipping_address_1();
$ciudad    = $pedido->get_shipping_city();
$pais      = $pedido->get_shipping_country();

// Líneas del pedido
foreach ( $pedido->get_items() as $item_id => $item ) {
    $nombre_producto = $item->get_name();
    $cantidad        = $item->get_quantity();
    $subtotal_item   = $item->get_subtotal();
    $product_id      = $item->get_product_id();
    $variation_id    = $item->get_variation_id();
}

// Cambiar estado
$pedido->update_status( 'completed', 'Completado manualmente.', true );

// Añadir nota interna
$pedido->add_order_note( 'Verificación manual completada por ' . wp_get_current_user()->display_name );
