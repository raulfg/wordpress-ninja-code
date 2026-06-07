// Prints the full <img> element with automatic srcset
the_post_thumbnail();

// With a specific size
the_post_thumbnail( 'large' );
the_post_thumbnail( 'portfolio-card' );

// Returns the <img> element as a string
$img = get_the_post_thumbnail( null, 'medium' );

// Returns the <img> for a specific post
$img = get_the_post_thumbnail( 42, 'thumbnail' );

// Only the featured image URL
$url = get_the_post_thumbnail_url( null, 'full' );

// Check before attempting to display
if ( has_post_thumbnail() ) {
    the_post_thumbnail( 'portfolio-card' );
}
