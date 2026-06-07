// Tipo de página
is_home()         // Página del blog (listado de entradas)
is_front_page()   // Portada del sitio (puede ser is_home() o una página estática)
is_single()       // Entrada individual de cualquier tipo
is_singular()     // Entrada, página o CPT individual
is_page()         // Página de WordPress
is_archive()      // Cualquier página de archivo
is_category()     // Archivo de categoría
is_tag()          // Archivo de etiqueta
is_tax()          // Archivo de taxonomía personalizada
is_author()       // Archivo de autor
is_date()         // Archivo de fecha
is_search()       // Resultados de búsqueda
is_404()          // Página de error 404

// Con parámetros para ser más específicos
is_page( 'sobre-nosotros' )         // Página con ese slug
is_single( 'mi-primer-post' )       // Entrada con ese slug
is_category( 'tecnologia' )         // Archivo de esa categoría
is_tax( 'portfolio_category', 'web' ) // Archivo de ese término concreto

// Estado del contenido
has_post_thumbnail()               // La entrada tiene imagen destacada
in_category( 'tutoriales' )        // La entrada está en esa categoría
has_tag( 'wordpress' )             // La entrada tiene esa etiqueta
has_term( 'web', 'portfolio_category' ) // Tiene ese término en esa taxonomía
is_sticky()                        // La entrada está fijada (sticky)
