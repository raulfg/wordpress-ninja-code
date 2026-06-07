class PortfolioRepository
{
    public function __construct( private \wpdb $db ) {}

    public function find_by_client( string $client_name ): array
    {
        return $this->db->get_results( $this->db->prepare(
            "SELECT p.ID FROM {$this->db->posts} p
             INNER JOIN {$this->db->postmeta} pm ON pm.post_id = p.ID
             WHERE p.post_type = %s
               AND p.post_status = %s
               AND pm.meta_key = %s
               AND pm.meta_value = %s",
            'portfolio', 'publish', '_npe_client_name', $client_name
        ) );
    }
}
