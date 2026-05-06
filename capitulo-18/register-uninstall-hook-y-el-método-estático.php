<?php
// Bloquear el acceso directo. WordPress define WP_UNINSTALL_PLUGIN
// justo antes de ejecutar este archivo; si no está definida, alguien
// lo está cargando fuera de ese contexto.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Respetar la preferencia del administrador: si activó la opción
// de conservar datos, no eliminar nada.
$settings = get_option( 'npe_settings', [] );
if ( ! empty( $settings['keep_data_on_uninstall'] ) ) {
    return;
}

// --- Opciones del plugin ---
delete_option( 'npe_settings' );
delete_option( 'npe_version' );

// --- Post meta registrado por el plugin ---
delete_post_meta_by_key( '_npe_project_url' );
delete_post_meta_by_key( '_npe_client_name' );

// --- Tabla personalizada (si existe) ---
global $wpdb;
$table_name = $wpdb->prefix . 'npe_stats';
// phpcs:ignore WordPress.DB.DirectDatabaseQuery
$wpdb->query( "DROP TABLE IF EXISTS `{$table_name}`" );
