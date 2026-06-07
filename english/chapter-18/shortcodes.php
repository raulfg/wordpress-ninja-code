public function render_portfolio( array|string $atts, ?string $content, string $tag ): string
{
    $atts = shortcode_atts(
        [
            'columns'  => 3,
            'category' => '',
            'limit'    => 9,
        ],
        $atts,
        $tag
    );

    $columns  = absint( $atts['columns'] );
    $category = sanitize_text_field( $atts['category'] );
    $limit    = absint( $atts['limit'] );

    // The shortcode RETURNS HTML, it never prints directly.
    return $this->get_portfolio_html( $columns, $category, $limit );
}
