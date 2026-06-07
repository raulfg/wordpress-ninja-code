add_action( 'restrict_manage_posts', function( string $post_type ): void {
    if ( 'portfolio' !== $post_type ) {
        return;
    }

    global $wpdb;
    $years = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT DISTINCT meta_value FROM {$wpdb->postmeta}
             WHERE meta_key = %s AND meta_value != ''
             ORDER BY meta_value DESC",
            '_npe_project_year'
        )
    );

    $selected = isset( $_GET['portfolio_year'] )
        ? absint( $_GET['portfolio_year'] )
        : 0;
    ?>
    <select name="portfolio_year">
        <option value="0">
            <?php esc_html_e( 'All years', 'ninja-portfolio' ); ?>
        </option>
        <?php foreach ( $years as $year ) : ?>
        <option value="<?php echo esc_attr( $year ); ?>"
            <?php selected( $selected, (int) $year ); ?>>
            <?php echo esc_html( $year ); ?>
        </option>
        <?php endforeach; ?>
    </select>
    <?php
} );
