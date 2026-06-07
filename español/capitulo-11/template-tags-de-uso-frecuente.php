// Títulos y contenido
the_title();                          // Título del post
get_the_title( $post_id );            // Título de un post específico
the_content();                        // Cuerpo del post con filtros aplicados
the_excerpt();                        // Extracto

// URLs y permalink
the_permalink();                      // URL del post actual
get_permalink( $post_id );            // URL de un post específico

// Fechas
the_date( 'd M Y' );                  // Fecha de publicación (solo la primera del día)
get_the_date( 'd M Y', $post_id );    // Fecha de un post específico (siempre)
the_modified_date( 'd M Y' );         // Fecha de última modificación
get_the_time( 'H:i' );               // Hora de publicación

// Autor
the_author();                         // Nombre del autor
get_the_author_meta( 'description' ); // Metadato del autor

// Imagen destacada
the_post_thumbnail( 'large' );        // Imagen en tamaño específico
get_the_post_thumbnail_url( get_the_ID(), 'medium' ); // URL de la imagen

// Taxonomías
the_category( ', ' );                 // Categorías como lista separada por comas
the_tags( 'Etiquetas: ', ', ' );     // Etiquetas con prefijo y separador
get_the_terms( get_the_ID(), 'portfolio-category' ); // Términos de cualquier taxonomía
