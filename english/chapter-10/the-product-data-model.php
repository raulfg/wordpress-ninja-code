$product = wc_get_product( $post_id );

// Check the type before operating
if ( ! $product ) {
    return;
}

// Basic data
$sku          = $product->get_sku();
$price        = $product->get_price();           // Active price (may be the sale price)
$regular_price = $product->get_regular_price();
$sale_price   = $product->get_sale_price();
$on_sale      = $product->is_on_sale();
$in_stock     = $product->is_in_stock();
$stock_qty    = $product->get_stock_quantity();

// Variable product: get variations
if ( $product->is_type( 'variable' ) ) {
    $variations  = $product->get_available_variations();
    $price_range = $product->get_price_html(); // "$10.00 - $25.00"
}

// Update product metadata
$product->set_sku( 'NINJA-001' );
$product->set_regular_price( '29.99' );
$product->save(); // Persists to the database
