// Devuelve la cadena traducida
__( 'Añadir proyecto', 'ninja-portfolio-enhancer' )

// Imprime la cadena traducida (equivale a echo __)
_e( 'No hay proyectos disponibles.', 'ninja-portfolio-enhancer' )

// Con contexto para desambiguar (la misma palabra puede traducirse diferente según el contexto)
_x( 'Portfolio', 'Nombre del menú de administración', 'ninja-portfolio-enhancer' )

// Singular y plural
_n(
    '%d proyecto encontrado',
    '%d proyectos encontrados',
    $count,
    'ninja-portfolio-enhancer'
)

// Versiones con escape (siempre usar en atributos HTML y salida directa)
esc_html__( 'Ver proyecto', 'ninja-portfolio-enhancer' )
esc_attr__( 'Cerrar', 'ninja-portfolio-enhancer' )
esc_html_e( 'Guardar cambios', 'ninja-portfolio-enhancer' )
