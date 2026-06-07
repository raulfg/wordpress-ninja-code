// wp-config.php with HyperDB
$wpdb->add_database( [
    'host'     => DB_HOST,         // Write: primary server
    'user'     => DB_USER,
    'password' => DB_PASSWORD,
    'name'     => DB_NAME,
    'write'    => 1,
    'read'     => 0,
] );

$wpdb->add_database( [
    'host'     => 'replica.servidor.com', // Read: replica
    'user'     => DB_USER_RO,
    'password' => DB_PASSWORD_RO,
    'name'     => DB_NAME,
    'write'    => 0,
    'read'     => 1,
] );
