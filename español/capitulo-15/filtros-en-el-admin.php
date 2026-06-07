add_action( 'restrict_manage_posts', function( string $post_type ): void {
    if ( 'portfolio' !== $post_type ) {
        return;
    }

    $current = isset( $_GET['portfolio_featured'] )
        ? (int) $_GET['portfolio_featured']
        : -1;
    ?>
    <select name="portfolio_featured">
        <option value="-1">Todos los proyectos</option>
        <option value="1" <?php selected( $current, 1 ); ?>>
            Solo destacados
        </option>
        <option value="0" <?php selected( $current, 0 ); ?>>
            Solo no destacados
        </option>
    </select>
    <?php
} );
