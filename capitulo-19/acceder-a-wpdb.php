class RepositorioPedidos
{
    private wpdb $wpdb;

    public function __construct(wpdb $wpdb)
    {
        $this->wpdb = $wpdb;
    }

    public function obtener_recientes(int $usuario_id): array
    {
        return $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$this->wpdb->prefix}pedidos WHERE usuario_id = %d",
                $usuario_id
            )
        );
    }
}

// En el punto de composición del plugin:
global $wpdb;
$repositorio = new RepositorioPedidos($wpdb);
