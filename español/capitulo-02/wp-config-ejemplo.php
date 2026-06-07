<?php
/**
 * Configuración de WordPress - Ejemplo para Desarrollo
 * 
 * Este archivo contiene las configuraciones más importantes para 
 * un entorno de desarrollo WordPress
 */

// ** Configuración de la base de datos ** //
define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'wordpress' );
define( 'DB_PASSWORD', 'wordpress_password' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

/**
 * Claves de autenticación únicas
 * Generar en: https://api.wordpress.org/secret-key/1.1/salt/
 */
define( 'AUTH_KEY',         'pon-aqui-tu-clave-unica-de-autenticacion' );
define( 'SECURE_AUTH_KEY',  'pon-aqui-tu-clave-unica-de-autenticacion-segura' );
define( 'LOGGED_IN_KEY',    'pon-aqui-tu-clave-unica-logged-in' );
define( 'NONCE_KEY',        'pon-aqui-tu-clave-unica-nonce' );
define( 'AUTH_SALT',        'pon-aqui-tu-sal-de-autenticacion' );
define( 'SECURE_AUTH_SALT', 'pon-aqui-tu-sal-de-autenticacion-segura' );
define( 'LOGGED_IN_SALT',   'pon-aqui-tu-sal-logged-in' );
define( 'NONCE_SALT',       'pon-aqui-tu-sal-nonce' );

/**
 * Prefijo de tabla de la base de datos de WordPress
 * Puedes cambiar este prefijo para mayor seguridad
 */
$table_prefix = 'wp_';

/**
 * Configuraciones para desarrollo
 */
// Habilitar modo debug
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

// Debug adicional para desarrollo
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );

// Configuración de memoria
define( 'WP_MEMORY_LIMIT', '256M' );

// Configuración de archivos
define( 'FS_METHOD', 'direct' );

// Deshabilitar actualizaciones automáticas en desarrollo
define( 'WP_AUTO_UPDATE_CORE', false );

// URLs del sitio (útil para Docker)
define( 'WP_HOME', 'http://localhost:8080' );
define( 'WP_SITEURL', 'http://localhost:8080' );

/**
 * Configuraciones adicionales opcionales
 */

// Aumentar el tiempo límite para subir archivos
define( 'WP_HTTP_BLOCK_EXTERNAL', false );

// Configurar directorio de uploads personalizado
// define( 'UPLOADS', 'wp-content/uploads' );

// Habilitar multisite (descomentaruna vez configurado)
// define( 'WP_ALLOW_MULTISITE', true );

// Configuración para SSL (en producción)
// define( 'FORCE_SSL_ADMIN', true );

/* ¡Eso es todo, deja de editar! Feliz publicación. */

/** Ruta absoluta al directorio de WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura las variables de WordPress y los archivos incluidos. */
require_once ABSPATH . 'wp-settings.php';