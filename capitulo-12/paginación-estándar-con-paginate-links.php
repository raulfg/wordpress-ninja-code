// En el archivo de plantilla (archive-portfolio.php, index.php, etc.)
global $wp_query;

$pagination = paginate_links( [
    'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
    'format'    => '?paged=%#%',
    'current'   => max( 1, get_query_var( 'paged' ) ),
    'total'     => $wp_query->max_num_pages,
    'prev_text' => '← Anterior',
    'next_text' => 'Siguiente →',
    'type'      => 'array', // Devolver array en lugar de string HTML
] );

if ( $pagination ) : ?>
    <nav class="pagination" aria-label="Paginación">
        <ul class="pagination__list">
            <?php foreach ( $pagination as $page ) : ?>
            <li class="pagination__item">
                <?php echo $page; // phpcs:ignore WordPress.Security.EscapeOutput — paginate_links escapa internamente ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
<?php endif;
