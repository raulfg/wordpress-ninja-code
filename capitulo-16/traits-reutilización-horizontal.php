trait HasAdminNotice
{
    public function show_notice( string $message, string $type = 'info' ): void
    {
        add_action( 'admin_notices', function () use ( $message, $type ): void {
            printf(
                '<div class="notice notice-%s is-dismissible"><p>%s</p></div>',
                esc_attr( $type ),
                esc_html( $message )
            );
        } );
    }
}

class Portfolio extends AbstractPostType
{
    use HasAdminNotice;

    public function register(): void
    {
        parent::register();

        if ( ! post_type_exists( 'portfolio' ) ) {
            $this->show_notice( 'Error al registrar el tipo de contenido Portfolio.', 'error' );
        }
    }
}
