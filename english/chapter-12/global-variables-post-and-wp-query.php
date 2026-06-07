global $post;

$post->ID             // Numeric ID — integer
$post->post_title     // Raw title (without the_title filters)
$post->post_content   // Raw content (without wpautop or shortcodes)
$post->post_excerpt   // Manual excerpt (may be empty)
$post->post_author    // Author user ID
$post->post_date      // Publication date: "2024-03-15 10:30:00"
$post->post_date_gmt  // Date in UTC
$post->post_modified  // Date of last modification
$post->post_status    // "publish", "draft", "private", etc.
$post->post_type      // "post", "page", "portfolio", etc.
$post->post_name      // Post slug (the URL segment)
$post->post_parent    // Parent post ID (for nested pages)
$post->menu_order     // Order in menus and galleries
$post->comment_status // "open" or "closed"
