// wp-config.php — va al repositorio
<?php

// Credenciales de producción (o vacías — se sobreescriben en local)
define( 'DB_NAME',     getenv( 'DB_NAME' )     ?: 'wordpress_prod' );
define( 'DB_USER',     getenv( 'DB_USER' )     ?: 'wp_user' );
define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) ?: '' );
define( 'DB_HOST',     getenv( 'DB_HOST' )     ?: 'localhost' );

// Incluir configuración local si existe (gitignored)
if ( file_exists( __DIR__ . '/wp-config-local.php' ) ) {
    require_once __DIR__ . '/wp-config-local.php';
}

// Claves de autenticación
define( 'AUTH_KEY',         '...' );
// ...

$table_prefix = 'wp_';

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}
require_once ABSPATH . 'wp-settings.php';
