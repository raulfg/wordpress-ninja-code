<?php
// Cargar las dependencias de Composer
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Configurar las variables de entorno del test
$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
    $_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

require_once $_tests_dir . '/includes/functions.php';

// Cargar el plugin antes de que WordPress cargue el test
tests_add_filter( 'muplugins_loaded', function(): void {
    require dirname( __DIR__ ) . '/ninja-portfolio-enhancer.php';
} );

require $_tests_dir . '/includes/bootstrap.php';
