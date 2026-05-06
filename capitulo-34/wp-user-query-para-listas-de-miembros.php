// Obtener todos los miembros PRO activos
$pro_members = new WP_User_Query( [
    'meta_query'  => [
        'relation' => 'AND',
        [
            'key'     => '_ninja_membership_plan',
            'value'   => 'pro',
            'compare' => '=',
        ],
        [
            'key'     => '_ninja_membership_expires',
            'value'   => current_time( 'mysql' ),
            'compare' => '>',
            'type'    => 'DATETIME',
        ],
    ],
    'orderby'     => 'meta_value',
    'meta_key'    => '_ninja_membership_expires',
    'order'       => 'ASC',
    'number'      => 50,
    'paged'       => max( 1, get_query_var( 'paged' ) ),
] );

$total = $pro_members->get_total();
$users = $pro_members->get_results();
