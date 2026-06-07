<?php

// The hook executes the actual work
add_action( 'my_plugin_sync_inventory', 'my_plugin_run_sync' );

function my_plugin_run_sync(): void {
    // task logic
}

// Schedule on plugin activation
register_activation_hook( __FILE__, 'my_plugin_activate_cron' );

function my_plugin_activate_cron(): void {
    if ( ! wp_next_scheduled( 'my_plugin_sync_inventory' ) ) {
        wp_schedule_event( time(), 'hourly', 'my_plugin_sync_inventory' );
    }
}

// Clean up on deactivation
register_deactivation_hook( __FILE__, 'my_plugin_deactivate_cron' );

function my_plugin_deactivate_cron(): void {
    $timestamp = wp_next_scheduled( 'my_plugin_sync_inventory' );
    if ( $timestamp ) {
        wp_unschedule_event( $timestamp, 'my_plugin_sync_inventory' );
    }
}
