<?php

// db-config.php — loaded instead of wp-db.php when HyperDB is active
$wpdb->add_database( [
    'host'     => DB_HOST,       // Primary server — reads and writes
    'user'     => DB_USER,
    'password' => DB_PASSWORD,
    'name'     => DB_NAME,
    'write'    => 1,
    'read'     => 1,
    'dataset'  => 'global',
    'timeout'  => 0.2,
] );

$wpdb->add_database( [
    'host'     => 'replica.db.internal',  // Replica — reads only
    'user'     => DB_USER,
    'password' => DB_PASSWORD,
    'name'     => DB_NAME,
    'write'    => 0,
    'read'     => 1,
    'dataset'  => 'global',
    'timeout'  => 0.2,
] );
