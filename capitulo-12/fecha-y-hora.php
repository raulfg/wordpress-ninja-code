// Fecha con el formato configurado en Ajustes → General
the_date();

// Devuelve la fecha
$fecha = get_the_date();

// Formato personalizado (notación PHP date())
$fecha = get_the_date( 'd/m/Y' );

// Fecha de modificación
$modificada = get_the_modified_date( 'd/m/Y' );

// Para mostrar "hace X tiempo" o fechas precisas con datetime
?>
<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
    <?php echo esc_html( get_the_date( 'd M Y' ) ); ?>
</time>
