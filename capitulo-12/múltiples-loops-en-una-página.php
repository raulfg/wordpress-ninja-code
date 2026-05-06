// Loop principal — usa la query automática de WordPress
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        // Contenido principal
    endwhile;
endif;

// Restaurar datos del post principal
wp_reset_postdata();

// Loop secundario con query personalizada
$custom_query = new WP_Query( array(
    'posts_per_page' => 5,
    'category_name'  => 'destacados',
) );

if ( $custom_query->have_posts() ) :
    while ( $custom_query->have_posts() ) : $custom_query->the_post();
        // Contenido secundario
    endwhile;
    wp_reset_postdata();
endif;
