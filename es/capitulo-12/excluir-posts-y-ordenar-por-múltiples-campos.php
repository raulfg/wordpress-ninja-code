// Excluir los últimos 3 proyectos del listado secundario
$ids_recientes = get_posts( [
    'post_type'   => 'portfolio',
    'numberposts' => 3,
    'fields'      => 'ids',
] );

$secundarios = new WP_Query( [
    'post_type'      => 'portfolio',
    'posts_per_page' => 9,
    'post__not_in'   => $ids_recientes,
    'orderby'        => [
        'meta_value_num' => 'DESC',
        'date'           => 'DESC',
    ],
    'meta_key'       => '_proyecto_rating',
] );
