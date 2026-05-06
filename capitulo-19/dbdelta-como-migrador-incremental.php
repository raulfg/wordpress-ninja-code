function ninjatheme_install_tables(): void {
    global $wpdb;

    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE {$wpdb->prefix}ninja_stats (
      ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      post_id bigint(20) unsigned NOT NULL,
      user_id bigint(20) unsigned NOT NULL DEFAULT 0,
      session_id varchar(64) NOT NULL DEFAULT '',
      event_type varchar(50) NOT NULL,
      event_value decimal(10,2) DEFAULT NULL,
      created_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      PRIMARY KEY  (ID),
      KEY post_id (post_id),
      KEY session_id (session_id),
      KEY post_event (post_id,event_type)
    ) {$charset};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}
