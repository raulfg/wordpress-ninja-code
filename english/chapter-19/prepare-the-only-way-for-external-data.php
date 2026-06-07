// Vulnerable: the value of $title comes from outside without sanitization
$title = $_GET['title']; // value: "'; DROP TABLE wp_posts; --"

// With sprintf(): the malicious string is inserted directly
$bad_query = sprintf(
    "SELECT * FROM wp_posts WHERE post_title = '%s'",
    $title
);
// Result: SELECT * FROM wp_posts WHERE post_title = ''; DROP TABLE wp_posts; --'

// With prepare(): the value is properly escaped
$safe_query = $wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE post_title = %s",
    $title
);
// Result: SELECT * FROM wp_posts WHERE post_title = '\'; DROP TABLE wp_posts; --'
