// Get all active subscribers with subscription meta
$query = new WP_User_Query( [
    'role'       => 'subscriber',
    'meta_query' => [
        [
            'key'     => 'suscripcion_estado',
            'value'   => 'activa',
            'compare' => '=',
        ],
    ],
    'number'  => 50,   // result limit
    'offset'  => 0,
    'orderby' => 'registered',
    'order'   => 'DESC',
] );

$usuarios = $query->get_results(); // array of WP_User
$total    = $query->get_total();   // int, total without number/offset applied
