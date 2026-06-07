global $wpdb;

// Get the number of published posts from all sites without switch_to_blog()
$sites      = get_sites( [ 'number' => 0 ] );
$site_stats = [];

foreach ( $sites as $site ) {
    $table = $wpdb->get_blog_prefix( $site->blog_id ) . 'posts';
    $count = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*) FROM {$table} WHERE post_type = %s AND post_status = %s",
            'post',
            'publish'
        )
    );
    $site_stats[ $site->blog_id ] = (int) $count;
}
