class Portfolio_Widget extends \WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'npe_portfolio_widget',
            __( 'Ninja Portfolio', 'ninja-portfolio-enhancer' ),
            [ 'description' => __( 'Muestra los últimos proyectos del portfolio.', 'ninja-portfolio-enhancer' ) ]
        );
    }

    /**
     * Renderiza el widget en el frontend.
     *
     * @param array $args     Parámetros del área de widgets (before_widget, after_widget, etc.)
     * @param array $instance Valores guardados del formulario del widget.
     */
    public function widget( $args, $instance ): void
    {
        echo $args['before_widget'];

        $title = apply_filters( 'widget_title', $instance['title'] ?? '' );

        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        $limit = absint( $instance['limit'] ?? 3 );
        echo do_shortcode( sprintf( '[ninja_portfolio limit="%d"]', $limit ) );

        echo $args['after_widget'];
    }

    /**
     * Renderiza el formulario en el escritorio de administración.
     */
    public function form( $instance ): void
    {
        $title = esc_attr( $instance['title'] ?? __( 'Proyectos recientes', 'ninja-portfolio-enhancer' ) );
        $limit = absint( $instance['limit'] ?? 3 );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Título:', 'ninja-portfolio-enhancer' ); ?></label>
            <input class="widefat"
                   id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                   type="text"
                   value="<?php echo $title; ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Número de proyectos:', 'ninja-portfolio-enhancer' ); ?></label>
            <input class="widefat"
                   id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>"
                   type="number"
                   min="1"
                   value="<?php echo $limit; ?>">
        </p>
        <?php
    }

    /**
     * Sanitiza y guarda los valores del formulario.
     */
    public function update( $new_instance, $old_instance ): array
    {
        return [
            'title' => sanitize_text_field( $new_instance['title'] ),
            'limit' => absint( $new_instance['limit'] ),
        ];
    }
}
