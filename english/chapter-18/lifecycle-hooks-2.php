// Prefer uninstall.php over register_uninstall_hook for greater control
// Create the uninstall.php file in the plugin root

// uninstall.php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die; // Direct access blocked
}

// User-controlled option: delete data on uninstall?
$delete_data = get_option( 'npe_delete_data_on_uninstall', false );

if ( $delete_data ) {
    global $wpdb;

    // Drop the analytics table
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}npe_analytics" );

    // Delete all plugin options
    $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'npe_%'" );

    // Delete all plugin post meta
    $wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE '_npe_%'" );

    // On Multisite: repeat for each site in the network
    if ( is_multisite() ) {
        $sites = get_sites( [ 'number' => 0 ] );
        foreach ( $sites as $site ) {
            switch_to_blog( $site->blog_id );
            $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'npe_%'" );
            $wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE '_npe_%'" );
            restore_current_blog();
        }
    }
}
