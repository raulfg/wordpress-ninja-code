// Vulnerable: el valor de $titulo llega del exterior sin sanear
$titulo = $_GET['titulo']; // valor: "'; DROP TABLE wp_posts; --"

// Con sprintf(): la cadena maliciosa se inserta directamente
$consulta_mala = sprintf(
    "SELECT * FROM wp_posts WHERE post_title = '%s'",
    $titulo
);
// Resultado: SELECT * FROM wp_posts WHERE post_title = ''; DROP TABLE wp_posts; --'

// Con prepare(): el valor queda escapado
$consulta_segura = $wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE post_title = %s",
    $titulo
);
// Resultado: SELECT * FROM wp_posts WHERE post_title = '\'; DROP TABLE wp_posts; --'
