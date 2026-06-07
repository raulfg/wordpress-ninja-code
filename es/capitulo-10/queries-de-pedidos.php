// Pedidos del último mes con estado completed
$pedidos = wc_get_orders( [
    'status'       => 'completed',
    'limit'        => 50,
    'orderby'      => 'date',
    'order'        => 'DESC',
    'date_created' => '>' . strtotime( '-30 days' ),
] );

// Pedidos de un cliente específico
$pedidos_cliente = wc_get_orders( [
    'customer_id' => $user_id,
    'limit'       => -1,     // Sin límite
    'status'      => [ 'completed', 'processing' ],
] );

$total_gastado = array_sum(
    array_map( fn( WC_Order $p ) => (float) $p->get_total(), $pedidos_cliente )
);
