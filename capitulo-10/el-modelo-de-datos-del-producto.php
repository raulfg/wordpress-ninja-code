$producto = wc_get_product( $post_id );

// Comprobar el tipo antes de operar
if ( ! $producto ) {
    return;
}

// Datos básicos
$sku        = $producto->get_sku();
$precio     = $producto->get_price();           // Precio activo (puede ser el de oferta)
$precio_reg = $producto->get_regular_price();
$precio_of  = $producto->get_sale_price();
$en_oferta  = $producto->is_on_sale();
$en_stock   = $producto->is_in_stock();
$stock_qty  = $producto->get_stock_quantity();

// Producto variable: obtener variaciones
if ( $producto->is_type( 'variable' ) ) {
    $variaciones = $producto->get_available_variations();
    $rango_precio = $producto->get_price_html(); // "€10,00 - €25,00"
}

// Actualizar metadatos del producto
$producto->set_sku( 'NINJA-001' );
$producto->set_regular_price( '29.99' );
$producto->save(); // Persiste en base de datos
