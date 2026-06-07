// En functions.php del tema o en el plugin
add_action( 'wp_ajax_ninja_load_more', 'ninja_handle_load_more' );
add_action( 'wp_ajax_nopriv_ninja_load_more', 'ninja_handle_load_more' );

function ninja_handle_load_more(): void {
    check_ajax_referer( 'ninja_load_more_nonce', 'nonce' );

    $page      = absint( $_POST['page'] ?? 1 );
    $post_type = sanitize_key( $_POST['post_type'] ?? 'post' );

    $allowed_types = [ 'post', 'portfolio', 'page' ];
    if ( ! in_array( $post_type, $allowed_types, true ) ) {
        wp_send_json_error( 'Tipo de post no permitido.', 400 );
    }

    $query = new WP_Query( [
        'post_type'      => $post_type,
        'post_status'    => 'publish',
        'posts_per_page' => 6,
        'paged'          => $page,
        'no_found_rows'  => false, // Necesario para calcular max_num_pages
    ] );

    if ( ! $query->have_posts() ) {
        wp_send_json_success( [
            'html'     => '',
            'has_more' => false,
        ] );
    }

    ob_start();
    while ( $query->have_posts() ) {
        $query->the_post();
        get_template_part( 'template-parts/components/portfolio-card', null, [
            'post_id' => get_the_ID(),
        ] );
    }
    wp_reset_postdata();

    $html = ob_get_clean();

    wp_send_json_success( [
        'html'     => $html,
        'has_more' => $page < $query->max_num_pages,
        'current'  => $page,
        'max'      => $query->max_num_pages,
    ] );
}
