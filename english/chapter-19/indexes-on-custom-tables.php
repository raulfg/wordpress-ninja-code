function ninjatheme_create_stats_table(): void {
    global $wpdb;

    $table   = $wpdb->prefix . 'ninja_stats';
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE {$table} (
      ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      post_id bigint(20) unsigned NOT NULL,
      user_id bigint(20) unsigned NOT NULL DEFAULT 0,
      event_type varchar(50) NOT NULL,
      event_value decimal(10,2) DEFAULT NULL,
      created_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      PRIMARY KEY  (ID),
      KEY post_id (post_id),
      KEY user_id (user_id),
      KEY event_type (event_type),
      KEY post_event (post_id,event_type),
      KEY created_at (created_at)
    ) {$charset};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}
