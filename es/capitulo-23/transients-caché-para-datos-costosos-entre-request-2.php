function obtener_con_lock( string $clave ): mixed {
    $datos = get_transient( $clave );

    if ( false !== $datos ) {
        return $datos;
    }

    $lock = get_transient( $clave . '_lock' );

    if ( $lock ) {
        // Otro proceso está regenerando; retornar valor obsoleto si existe
        return get_option( $clave . '_stale', [] );
    }

    set_transient( $clave . '_lock', true, 30 );

    $datos = generar_datos_costosos();
    set_transient( $clave, $datos, HOUR_IN_SECONDS );
    update_option( $clave . '_stale', $datos, false );
    delete_transient( $clave . '_lock' );

    return $datos;
}
