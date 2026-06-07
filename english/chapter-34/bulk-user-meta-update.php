$query = new WP_User_Query( [
    'meta_query' => [
        [
            'key'     => 'suscripcion_fecha_vencimiento',
            'value'   => current_time( 'mysql' ),
            'compare' => '<',
            'type'    => 'DATETIME',
        ],
    ],
    'fields' => 'ID',   // we only need the IDs
    'number' => 100,
] );

foreach ( $query->get_results() as $user_id ) {
    update_user_meta( $user_id, 'suscripcion_estado', 'vencida' );
}
