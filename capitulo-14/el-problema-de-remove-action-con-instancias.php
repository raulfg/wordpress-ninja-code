class NinjaTheme
{
	private static ?NinjaTheme $instance = null;

	public static function get_instance(): NinjaTheme
	{
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function hooks(): void
	{
		add_action( 'wp_head', [ $this, 'inyectar_estilos_criticos' ], 5 );
	}

	public function inyectar_estilos_criticos(): void
	{
		// ...
	}
}

$tema = NinjaTheme::get_instance();
$tema->hooks();

// Más adelante, otro plugin puede eliminarlo con:
remove_action( 'wp_head', [ NinjaTheme::get_instance(), 'inyectar_estilos_criticos' ], 5 );
