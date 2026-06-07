<?php
// product-importer.php — run with: wp eval-file product-importer.php

declare( strict_types=1 );

// Configuration
$csv_file    = __DIR__ . '/data/productos.csv';
$batch_size  = 50;   // Process in batches to avoid memory exhaustion
$dry_run     = false; // true to simulate without inserting

// Read the CSV
$handle = fopen( $csv_file, 'r' );
if ( ! $handle ) {
    WP_CLI::error( "Could not open file: {$csv_file}" );
}

$headers = fgetcsv( $handle ); // First row = headers
$count   = 0;
$errors  = 0;

WP_CLI::log( "Starting import. Dry run: " . ( $dry_run ? 'YES' : 'NO' ) );

while ( ( $row = fgetcsv( $handle ) ) !== false ) {
    $data = array_combine( $headers, $row );

    // Idempotency: check if a post with this external ID already exists
    $existing = get_posts( [
        'meta_key'   => '_import_id_externo',
        'meta_value' => $data['id'],
        'post_type'  => 'producto',
        'post_status'=> 'any',
        'numberposts'=> 1,
    ] );

    if ( ! empty( $existing ) ) {
        WP_CLI::log( "Already exists: {$data['nombre']} (external ID: {$data['id']})" );
        continue;
    }

    if ( $dry_run ) {
        WP_CLI::log( "[DRY RUN] Would insert: {$data['nombre']}" );
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
        WP_CLI::warning( "Error inserting {$data['nombre']}: " . $post_id->get_error_message() );
        $errors++;
        continue;
    }

    // Save the external ID for idempotency
    update_post_meta( $post_id, '_import_id_externo', $data['id'] );
    update_post_meta( $post_id, '_precio', floatval( $data['precio'] ) );

    $count++;

    // Show progress every $batch_size posts
    if ( 0 === $count % $batch_size ) {
        WP_CLI::log( "Processed: {$count}" );
        // Clear cache to avoid memory accumulation
        wp_cache_flush();
    }
}

fclose( $handle );

WP_CLI::success( "Import completed. Inserted: {$count}. Errors: {$errors}." );
