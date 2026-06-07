// Exclude the 3 most recent projects from the secondary listing
$recent_ids = get_posts( [
    'post_type'   => 'portfolio',
    'numberposts' => 3,
    'fields'      => 'ids',
] );

$secondary = new WP_Query( [
    'post_type'      => 'portfolio',
    'posts_per_page' => 9,
    'post__not_in'   => $recent_ids,
    'orderby'        => [
        'meta_value_num' => 'DESC',
        'date'           => 'DESC',
    ],
    'meta_key'       => '_proyecto_rating',
] );
