register_activation_hook(__FILE__, 'myplugin_create_tables');

function myplugin_create_tables(): void
{
    global $wpdb;

    $table   = $wpdb->prefix . 'orders';
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE {$table} (
  ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  user_id bigint(20) unsigned NOT NULL,
  total decimal(10,2) NOT NULL DEFAULT '0.00',
  status varchar(20) NOT NULL DEFAULT 'pending',
  date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (ID),
  KEY user_id (user_id),
  KEY status (status)
) {$charset};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);

    add_option('myplugin_db_version', '1.0');
}
