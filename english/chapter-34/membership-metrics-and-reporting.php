/**
 * Gets membership metrics for a given period.
 *
 * @param string $start Start date in Y-m-d format.
 * @param string $end   End date in Y-m-d format.
 * @return array
 */
function ninja_get_membership_metrics( string $start, string $end ): array {
    global $wpdb;

    // New active memberships in the period
    $new_members = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}mepr_transactions
         WHERE status = 'complete'
         AND created_at BETWEEN %s AND %s",
        $start . ' 00:00:00',
        $end   . ' 23:59:59'
    ) );

    // Memberships cancelled in the period
    $cancelled = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}mepr_subscriptions
         WHERE status = 'cancelled'
         AND updated_at BETWEEN %s AND %s",
        $start . ' 00:00:00',
        $end   . ' 23:59:59'
    ) );

    // Revenue for the period
    $revenue = (float) $wpdb->get_var( $wpdb->prepare(
        "SELECT COALESCE(SUM(total), 0) FROM {$wpdb->prefix}mepr_transactions
         WHERE status = 'complete'
         AND created_at BETWEEN %s AND %s",
        $start . ' 00:00:00',
        $end   . ' 23:59:59'
    ) );

    // Total active members at end of period
    $active = (int) $wpdb->get_var(
        "SELECT COUNT(DISTINCT user_id) FROM {$wpdb->prefix}mepr_transactions
         WHERE status = 'complete'
         AND expires_at > NOW()"
    );

    return [
        'new_members' => $new_members,
        'cancelled'   => $cancelled,
        'revenue'     => $revenue,
        'active'      => $active,
        'churn_rate'  => $active > 0 ? round( ( $cancelled / $active ) * 100, 2 ) : 0,
    ];
}
