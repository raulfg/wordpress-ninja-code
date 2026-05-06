// Obtener todos los suscriptores activos con meta de suscripción
$query = new WP_User_Query( [
    'role'       => 'subscriber',
    'meta_query' => [
        [
            'key'     => 'suscripcion_estado',
            'value'   => 'activa',
            'compare' => '=',
        ],
    ],
    'number'  => 50,   // límite de resultados
    'offset'  => 0,
    'orderby' => 'registered',
    'order'   => 'DESC',
] );

$usuarios = $query->get_results(); // array de WP_User
$total    = $query->get_total();   // int, total sin aplicar number/offset
