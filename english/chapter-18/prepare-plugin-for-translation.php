// Returns the translated string
__( 'Add project', 'ninja-portfolio-enhancer' )

// Prints the translated string (equivalent to echo __)
_e( 'No projects available.', 'ninja-portfolio-enhancer' )

// With context to disambiguate (the same word may translate differently depending on context)
_x( 'Portfolio', 'Administration menu name', 'ninja-portfolio-enhancer' )

// Singular and plural
_n(
    '%d project found',
    '%d projects found',
    $count,
    'ninja-portfolio-enhancer'
)

// Escaped versions (always use in HTML attributes and direct output)
esc_html__( 'View project', 'ninja-portfolio-enhancer' )
esc_attr__( 'Close', 'ninja-portfolio-enhancer' )
esc_html_e( 'Save changes', 'ninja-portfolio-enhancer' )
