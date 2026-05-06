class AbstractPostType
{
    // Solo accesible desde dentro de esta clase
    private string $registered_at;

    // Accesible desde esta clase y desde las clases hijas
    protected string $namespace = 'NinjaTheme';

    // Accesible desde cualquier lugar
    public function register(): void { /* ... */ }

    // Solo accesible desde esta clase
    private function log_registration(): void
    {
        $this->registered_at = current_time( 'mysql' );
    }
}
