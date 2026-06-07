class AbstractPostType
{
    // Accessible only from within this class
    private string $registered_at;

    // Accessible from this class and child classes
    protected string $namespace = 'NinjaTheme';

    // Accessible from anywhere
    public function register(): void { /* ... */ }

    // Accessible only from within this class
    private function log_registration(): void
    {
        $this->registered_at = current_time( 'mysql' );
    }
}
