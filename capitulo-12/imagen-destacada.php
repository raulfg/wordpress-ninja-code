// Imprime el elemento <img> completo con srcset automático
the_post_thumbnail();

// Con tamaño específico
the_post_thumbnail( 'large' );
the_post_thumbnail( 'portfolio-card' );

// Devuelve el elemento <img> como cadena
$img = get_the_post_thumbnail( null, 'medium' );

// Devuelve el <img> de una entrada concreta
$img = get_the_post_thumbnail( 42, 'thumbnail' );

// Solo la URL de la imagen destacada
$url = get_the_post_thumbnail_url( null, 'full' );

// Verificar antes de intentar mostrar
if ( has_post_thumbnail() ) {
    the_post_thumbnail( 'portfolio-card' );
}
