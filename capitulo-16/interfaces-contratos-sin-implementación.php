class Portfolio extends AbstractPostType implements HasMetaFields
{
    protected function get_post_type(): string { return 'portfolio'; }
    protected function get_args(): array { /* ... */ }

    public function get_meta_fields(): array
    {
        return [
            '_npe_project_url' => [
                'type'         => 'string',
                'show_in_rest' => true,
                'single'       => true,
            ],
            '_npe_client_name' => [
                'type'         => 'string',
                'show_in_rest' => true,
                'single'       => true,
            ],
        ];
    }

    public function register_meta_fields(): void
    {
        foreach ( $this->get_meta_fields() as $key => $args ) {
            register_post_meta( $this->get_post_type(), $key, $args );
        }
    }
}
