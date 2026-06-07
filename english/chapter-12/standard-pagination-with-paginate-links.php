// In the template file (archive-portfolio.php, index.php, etc.)
global $wp_query;

$pagination = paginate_links( [
    'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
    'format'    => '?paged=%#%',
    'current'   => max( 1, get_query_var( 'paged' ) ),
    'total'     => $wp_query->max_num_pages,
    'prev_text' => '← Previous',
    'next_text' => 'Next →',
    'type'      => 'array', // Return array instead of HTML string
] );

if ( $pagination ) : ?>
    <nav class="pagination" aria-label="Pagination">
        <ul class="pagination__list">
            <?php foreach ( $pagination as $page ) : ?>
            <li class="pagination__item">
                <?php echo $page; // phpcs:ignore WordPress.Security.EscapeOutput — paginate_links escapes internally ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
<?php endif;
