// db-config.php — cargado en lugar de wp-db.php cuando HyperDB está activo
$wpdb->add_database( [
    'host'     => DB_HOST,       // Servidor primario — lecturas y escrituras
    'user'     => DB_USER,
    'password' => DB_PASSWORD,
    'name'     => DB_NAME,
    'write'    => 1,
    'read'     => 1,
    'dataset'  => 'global',
    'timeout'  => 0.2,
] );

$wpdb->add_database( [
    'host'     => 'replica.db.internal',  // Réplica — solo lecturas
    'user'     => DB_USER,
    'password' => DB_PASSWORD,
    'name'     => DB_NAME,
    'write'    => 0,
    'read'     => 1,
    'dataset'  => 'global',
    'timeout'  => 0.2,
] );
