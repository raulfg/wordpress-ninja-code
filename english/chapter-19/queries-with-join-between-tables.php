/**
 * Gets featured projects with their main category.
 *
 * @return array Array of objects with post_id, title, client, category_name.
 */
function ninja_get_featured_with_category(): array {
    global $wpdb;

    return $wpdb->get_results( $wpdb->prepare(
        "SELECT
            p.ID             AS post_id,
            p.post_title     AS title,
            pm.meta_value    AS client,
            t.name           AS category_name,
            t.slug           AS category_slug

         FROM {$wpdb->posts} p

         -- Client metadata
         LEFT JOIN {$wpdb->postmeta} pm
             ON pm.post_id  = p.ID
             AND pm.meta_key = '_npe_client_name'

         -- Taxonomy: portfolio-category
         LEFT JOIN {$wpdb->term_relationships} tr
             ON tr.object_id = p.ID

         LEFT JOIN {$wpdb->term_taxonomy} tt
             ON tt.term_taxonomy_id = tr.term_taxonomy_id
             AND tt.taxonomy = 'portfolio-category'

         LEFT JOIN {$wpdb->terms} t
             ON t.term_id = tt.term_id

         -- Featured and published posts only
         INNER JOIN {$wpdb->postmeta} pm_featured
             ON pm_featured.post_id  = p.ID
             AND pm_featured.meta_key = '_npe_is_featured'
             AND pm_featured.meta_value = '1'

         WHERE p.post_type   = 'portfolio'
           AND p.post_status = 'publish'

         GROUP BY p.ID, pm.meta_value, t.name, t.slug
         ORDER BY p.menu_order ASC, p.post_date DESC
         LIMIT %d",
        20
    ) );
}
