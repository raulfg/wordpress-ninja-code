// Date using the format configured in Settings → General
the_date();

// Returns the date
$date = get_the_date();

// Custom format (PHP date() notation)
$date = get_the_date( 'd/m/Y' );

// Modification date
$modified = get_the_modified_date( 'd/m/Y' );

// To display "X time ago" or precise dates with datetime
?>
<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
    <?php echo esc_html( get_the_date( 'd M Y' ) ); ?>
</time>
