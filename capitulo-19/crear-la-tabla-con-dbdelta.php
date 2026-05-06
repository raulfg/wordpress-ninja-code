register_activation_hook(__FILE__, 'miplugin_crear_tablas');

function miplugin_crear_tablas(): void
{
    global $wpdb;

    $tabla  = $wpdb->prefix . 'pedidos';
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE {$tabla} (
  ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  usuario_id bigint(20) unsigned NOT NULL,
  total decimal(10,2) NOT NULL DEFAULT '0.00',
  estado varchar(20) NOT NULL DEFAULT 'pendiente',
  fecha datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (ID),
  KEY usuario_id (usuario_id),
  KEY estado (estado)
) {$charset};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);

    add_option('miplugin_db_version', '1.0');
}
