/**
 * Obtiene las métricas de membresía para un período.
 *
 * @param string $start Fecha de inicio en formato Y-m-d.
 * @param string $end   Fecha de fin en formato Y-m-d.
 * @return array
 */
function ninja_get_membership_metrics( string $start, string $end ): array {
    global $wpdb;

    // Nuevas membresías activas en el período
    $new_members = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}mepr_transactions
         WHERE status = 'complete'
         AND created_at BETWEEN %s AND %s",
        $start . ' 00:00:00',
        $end   . ' 23:59:59'
    ) );

    // Membresías canceladas en el período
    $cancelled = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}mepr_subscriptions
         WHERE status = 'cancelled'
         AND updated_at BETWEEN %s AND %s",
        $start . ' 00:00:00',
        $end   . ' 23:59:59'
    ) );

    // Ingresos del período
    $revenue = (float) $wpdb->get_var( $wpdb->prepare(
        "SELECT COALESCE(SUM(total), 0) FROM {$wpdb->prefix}mepr_transactions
         WHERE status = 'complete'
         AND created_at BETWEEN %s AND %s",
        $start . ' 00:00:00',
        $end   . ' 23:59:59'
    ) );

    // Total de miembros activos al final del período
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
