<?php
// importador-productos.php — se ejecuta con: wp eval-file importador-productos.php

declare( strict_types=1 );

// Configuración
$csv_file    = __DIR__ . '/data/productos.csv';
$batch_size  = 50;   // Procesar en batches para evitar agotamiento de memoria
$dry_run     = false; // true para simular sin insertar

// Leer el CSV
$handle = fopen( $csv_file, 'r' );
if ( ! $handle ) {
    WP_CLI::error( "No se pudo abrir el archivo: {$csv_file}" );
}

$headers = fgetcsv( $handle ); // Primera fila = cabeceras
$count   = 0;
$errors  = 0;

WP_CLI::log( "Iniciando importación. Dry run: " . ( $dry_run ? 'SÍ' : 'NO' ) );

while ( ( $row = fgetcsv( $handle ) ) !== false ) {
    $data = array_combine( $headers, $row );

    // Idempotencia: comprobar si ya existe un post con este ID externo
    $existing = get_posts( [
        'meta_key'   => '_import_id_externo',
        'meta_value' => $data['id'],
        'post_type'  => 'producto',
        'post_status'=> 'any',
        'numberposts'=> 1,
    ] );

    if ( ! empty( $existing ) ) {
        WP_CLI::log( "Ya existe: {$data['nombre']} (ID externo: {$data['id']})" );
        continue;
    }

    if ( $dry_run ) {
        WP_CLI::log( "[DRY RUN] Insertaría: {$data['nombre']}" );
        $count++;
        continue;
    }

    $post_id = wp_insert_post( [
        'post_title'   => sanitize_text_field( $data['nombre'] ),
        'post_content' => wp_kses_post( $data['descripcion'] ),
        'post_status'  => 'publish',
        'post_type'    => 'producto',
    ], true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( "Error al insertar {$data['nombre']}: " . $post_id->get_error_message() );
        $errors++;
        continue;
    }

    // Guardar el ID externo para idempotencia
    update_post_meta( $post_id, '_import_id_externo', $data['id'] );
    update_post_meta( $post_id, '_precio', floatval( $data['precio'] ) );

    $count++;

    // Mostrar progreso cada $batch_size posts
    if ( 0 === $count % $batch_size ) {
        WP_CLI::log( "Procesados: {$count}" );
        // Limpiar la caché para evitar acumulación de memoria
        wp_cache_flush();
    }
}

fclose( $handle );

WP_CLI::success( "Importación completada. Insertados: {$count}. Errores: {$errors}." );
