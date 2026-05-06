global $post;

$post->ID             // ID numérico — integer
$post->post_title     // Título sin procesar (sin filtros de the_title)
$post->post_content   // Contenido sin procesar (sin wpautop ni shortcodes)
$post->post_excerpt   // Extracto manual (puede estar vacío)
$post->post_author    // ID del usuario autor
$post->post_date      // Fecha de publicación: "2024-03-15 10:30:00"
$post->post_date_gmt  // Fecha en UTC
$post->post_modified  // Fecha de última modificación
$post->post_status    // "publish", "draft", "private", etc.
$post->post_type      // "post", "page", "portfolio", etc.
$post->post_name      // Slug del post (la parte de la URL)
$post->post_parent    // ID del post padre (para páginas anidadas)
$post->menu_order     // Orden en menús y galerías
$post->comment_status // "open" o "closed"
