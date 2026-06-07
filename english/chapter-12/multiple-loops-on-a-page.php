// Main loop — uses WordPress's automatic query
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        // Main content
    endwhile;
endif;

// Restore main post data
wp_reset_postdata();

// Secondary loop with a custom query
$custom_query = new WP_Query( array(
    'posts_per_page' => 5,
    'category_name'  => 'featured',
) );

if ( $custom_query->have_posts() ) :
    while ( $custom_query->have_posts() ) : $custom_query->the_post();
        // Secondary content
    endwhile;
    wp_reset_postdata();
endif;
