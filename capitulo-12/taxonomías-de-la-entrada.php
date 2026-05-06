// Categorías y etiquetas con enlace a sus archivos
the_category( ', ' );    // "Desarrollo, JavaScript"
the_tags( '', ', ', '' );

// Devuelve arrays de objetos WP_Term
$categorias = get_the_category();
$etiquetas  = get_the_tags();

// Para cualquier taxonomía personalizada
$terminos = get_the_terms( get_the_ID(), 'portfolio_category' );

if ( $terminos && ! is_wp_error( $terminos ) ) {
    foreach ( $terminos as $termino ) {
        echo '<a href="' . esc_url( get_term_link( $termino ) ) . '">';
        echo esc_html( $termino->name );
        echo '</a>';
    }
}
