// Activar el modo de debug
define( 'WP_DEBUG', true );

// Escribir errores en el archivo de log en lugar de mostrarlos en pantalla
// (imprescindible en producción si WP_DEBUG está activo)
define( 'WP_DEBUG_LOG', true );     // Escribe en wp-content/debug.log
define( 'WP_DEBUG_DISPLAY', false ); // No mostrar errores en pantalla

// Ruta personalizada para el log (desde WordPress 5.1)
define( 'WP_DEBUG_LOG', '/var/log/wordpress/debug.log' );

// Desactivar la concatenación de scripts en el admin
define( 'CONCATENATE_SCRIPTS', false );

// Usar versiones no minificadas de scripts del core
define( 'SCRIPT_DEBUG', true );

// Guardar las queries en $wpdb->queries para análisis
define( 'SAVEQUERIES', true );
