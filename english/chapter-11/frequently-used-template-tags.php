// Titles and content
the_title();                          // Post title
get_the_title( $post_id );            // Title of a specific post
the_content();                        // Post body with filters applied
the_excerpt();                        // Excerpt

// URLs and permalink
the_permalink();                      // URL of the current post
get_permalink( $post_id );            // URL of a specific post

// Dates
the_date( 'd M Y' );                  // Publication date (only the first one of the day)
get_the_date( 'd M Y', $post_id );    // Date of a specific post (always)
the_modified_date( 'd M Y' );         // Date of last modification
get_the_time( 'H:i' );               // Publication time

// Author
the_author();                         // Author name
get_the_author_meta( 'description' ); // Author metadata

// Featured image
the_post_thumbnail( 'large' );        // Image at a specific size
get_the_post_thumbnail_url( get_the_ID(), 'medium' ); // Image URL

// Taxonomies
the_category( ', ' );                 // Categories as a comma-separated list
the_tags( 'Tags: ', ', ' );          // Tags with prefix and separator
get_the_terms( get_the_ID(), 'portfolio-category' ); // Terms from any taxonomy
