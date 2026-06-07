<?php
// Block direct access. WordPress defines WP_UNINSTALL_PLUGIN
// just before running this file; if it is not defined, someone
// is loading it outside that context.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Respect the administrator's preference: if they enabled the option
// to keep data, do not delete anything.
$settings = get_option( 'npe_settings', [] );
if ( ! empty( $settings['keep_data_on_uninstall'] ) ) {
    return;
}

// --- Plugin options ---
delete_option( 'npe_settings' );
delete_option( 'npe_version' );

// --- Post meta registered by the plugin ---
delete_post_meta_by_key( '_npe_project_url' );
delete_post_meta_by_key( '_npe_client_name' );

// --- Custom table (if it exists) ---
global $wpdb;
$table_name = $wpdb->prefix . 'npe_stats';
// phpcs:ignore WordPress.DB.DirectDatabaseQuery
$wpdb->query( "DROP TABLE IF EXISTS `{$table_name}`" );
