$order = wc_get_order( $order_id );

// Order data
$total     = $order->get_total();
$subtotal  = $order->get_subtotal();
$status    = $order->get_status();           // 'pending', 'processing', 'completed'...
$customer  = $order->get_user_id();
$email     = $order->get_billing_email();
$date      = $order->get_date_created();

// Shipping address
$name      = $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name();
$address   = $order->get_shipping_address_1();
$city      = $order->get_shipping_city();
$country   = $order->get_shipping_country();

// Order line items
foreach ( $order->get_items() as $item_id => $item ) {
    $product_name  = $item->get_name();
    $quantity      = $item->get_quantity();
    $item_subtotal = $item->get_subtotal();
    $product_id    = $item->get_product_id();
    $variation_id  = $item->get_variation_id();
}

// Change status
$order->update_status( 'completed', 'Manually completed.', true );

// Add internal note
$order->add_order_note( 'Manual verification completed by ' . wp_get_current_user()->display_name );
