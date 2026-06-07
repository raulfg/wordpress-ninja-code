add_action( 'admin_menu', function(): void {
    add_submenu_page(
        'memberpress',
        'Business metrics',
        'Metrics',
        'manage_options',
        'ninja-membership-metrics',
        'ninja_render_metrics_page'
    );
} );

function ninja_render_metrics_page(): void {
    $current_month = ninja_get_membership_metrics(
        date( 'Y-m-01' ),
        date( 'Y-m-t' )
    );
    $last_month = ninja_get_membership_metrics(
        date( 'Y-m-01', strtotime( 'first day of last month' ) ),
        date( 'Y-m-t', strtotime( 'last day of last month' ) )
    );
    ?>
    <div class="wrap">
        <h1>Membership metrics</h1>
        <div class="metrics-grid">
            <div class="metric-card">
                <h3>New members</h3>
                <span class="metric-value"><?php echo (int) $current_month['new_members']; ?></span>
                <span class="metric-delta">
                    <?php echo ninja_format_delta(
                        $current_month['new_members'],
                        $last_month['new_members']
                    ); ?>
                </span>
            </div>
            <div class="metric-card">
                <h3>Monthly churn</h3>
                <span class="metric-value"><?php echo $current_month['churn_rate']; ?>%</span>
            </div>
            <div class="metric-card">
                <h3>Monthly revenue</h3>
                <span class="metric-value"><?php echo number_format( $current_month['revenue'], 2 ); ?> €</span>
            </div>
            <div class="metric-card">
                <h3>Active members</h3>
                <span class="metric-value"><?php echo (int) $current_month['active']; ?></span>
            </div>
        </div>
    </div>
    <?php
}
