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
		add_action( 'wp_head', [ $this, 'inject_critical_styles' ], 5 );
	}

	public function inject_critical_styles(): void
	{
		// ...
	}
}

$tema = NinjaTheme::get_instance();
$tema->hooks();

// Later, another plugin can remove it with:
remove_action( 'wp_head', [ NinjaTheme::get_instance(), 'inject_critical_styles' ], 5 );
