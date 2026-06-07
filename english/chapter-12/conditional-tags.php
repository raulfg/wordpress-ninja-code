// Page type
is_home()         // Blog page (post listing)
is_front_page()   // Site front page (can be is_home() or a static page)
is_single()       // Individual post of any type
is_singular()     // Individual post, page, or CPT
is_page()         // WordPress page
is_archive()      // Any archive page
is_category()     // Category archive
is_tag()          // Tag archive
is_tax()          // Custom taxonomy archive
is_author()       // Author archive
is_date()         // Date archive
is_search()       // Search results
is_404()          // 404 error page

// With parameters to be more specific
is_page( 'about-us' )               // Page with that slug
is_single( 'my-first-post' )        // Post with that slug
is_category( 'technology' )         // Archive for that category
is_tax( 'portfolio_category', 'web' ) // Archive for that specific term

// Content state
has_post_thumbnail()               // Post has a featured image
in_category( 'tutorials' )         // Post belongs to that category
has_tag( 'wordpress' )             // Post has that tag
has_term( 'web', 'portfolio_category' ) // Has that term in that taxonomy
is_sticky()                        // Post is pinned (sticky)
