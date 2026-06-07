function obtener_con_lock( string $clave ): mixed {
    $datos = get_transient( $clave );

    if ( false !== $datos ) {
        return $datos;
    }

    $lock = get_transient( $clave . '_lock' );

    if ( $lock ) {
        // Another process is regenerating; return stale value if it exists
        return get_option( $clave . '_stale', [] );
    }

    set_transient( $clave . '_lock', true, 30 );

    $datos = generar_datos_costosos();
    set_transient( $clave, $datos, HOUR_IN_SECONDS );
    update_option( $clave . '_stale', $datos, false );
    delete_transient( $clave . '_lock' );

    return $datos;
}
