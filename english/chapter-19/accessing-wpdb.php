class OrderRepository
{
    private wpdb $wpdb;

    public function __construct(wpdb $wpdb)
    {
        $this->wpdb = $wpdb;
    }

    public function get_recent(int $user_id): array
    {
        return $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$this->wpdb->prefix}orders WHERE user_id = %d",
                $user_id
            )
        );
    }
}

// At the plugin composition root:
global $wpdb;
$repository = new OrderRepository($wpdb);
