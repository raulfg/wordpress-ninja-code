function obtener_datos_api_externa(): array {
    $clave_transient = 'datos_api_externa_v1';
    $datos = get_transient( $clave_transient );

    if ( false !== $datos ) {
        return $datos;
    }

    $respuesta = wp_remote_get( 'https://api.ejemplo.com/datos' );

    if ( is_wp_error( $respuesta ) ) {
        return [];
    }

    $datos = json_decode( wp_remote_retrieve_body( $respuesta ), true );
    set_transient( $clave_transient, $datos, HOUR_IN_SECONDS );

    return $datos;
}
