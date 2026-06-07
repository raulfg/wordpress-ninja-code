// Categories and tags with links to their archives
the_category( ', ' );    // "Development, JavaScript"
the_tags( '', ', ', '' );

// Returns arrays of WP_Term objects
$categories = get_the_category();
$tags       = get_the_tags();

// For any custom taxonomy
$terms = get_the_terms( get_the_ID(), 'portfolio_category' );

if ( $terms && ! is_wp_error( $terms ) ) {
    foreach ( $terms as $term ) {
        echo '<a href="' . esc_url( get_term_link( $term ) ) . '">';
        echo esc_html( $term->name );
        echo '</a>';
    }
}
