// Todos los sitios activos de la red
$sites = get_sites( [
    'number'   => 0,     // 0 = sin límite
    'archived' => 0,
    'spam'     => 0,
    'deleted'  => 0,
] );

// Sitios registrados en los últimos 30 días
$recientes = get_sites( [
    'number'       => 10,
    'registered__gte' => date( 'Y-m-d', strtotime( '-30 days' ) ),
] );

// Contar sitios de la red
$total = get_sites( [ 'count' => true ] );
