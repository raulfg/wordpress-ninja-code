// Create FULLTEXT index on wp_posts (run only once)
function ninja_create_fulltext_index(): void {
    global $wpdb;

    // Check if the index already exists
    $index_exists = $wpdb->get_var(
        "SELECT COUNT(*) FROM information_schema.STATISTICS
         WHERE table_schema = DATABASE()
         AND table_name = '{$wpdb->posts}'
         AND index_name = 'ninja_fulltext'"
    );

    if ( $index_exists ) {
        return;
    }

    // FULLTEXT indexes require the entire table to be locked during creation.
    // Run this during low-traffic hours or at installation time.
    $wpdb->query(
        "ALTER TABLE {$wpdb->posts}
         ADD FULLTEXT INDEX ninja_fulltext (post_title, post_content)"
    );
}

register_activation_hook( __FILE__, 'ninja_create_fulltext_index' );
