// Orders from the last month with completed status
$orders = wc_get_orders( [
    'status'       => 'completed',
    'limit'        => 50,
    'orderby'      => 'date',
    'order'        => 'DESC',
    'date_created' => '>' . strtotime( '-30 days' ),
] );

// Orders for a specific customer
$customer_orders = wc_get_orders( [
    'customer_id' => $user_id,
    'limit'       => -1,     // No limit
    'status'      => [ 'completed', 'processing' ],
] );

$total_spent = array_sum(
    array_map( fn( WC_Order $o ) => (float) $o->get_total(), $customer_orders )
);
