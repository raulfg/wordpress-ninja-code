add_shortcode( 'ninja_member_dashboard', function(): string {
    if ( ! is_user_logged_in() ) {
        return sprintf(
            '<p>%s <a href="%s">%s</a></p>',
            esc_html__( 'Para ver tu dashboard, debes', 'ninja-membership' ),
            esc_url( wp_login_url( get_permalink() ) ),
            esc_html__( 'iniciar sesión', 'ninja-membership' )
        );
    }

    $user_id    = get_current_user_id();
    $membership = ninja_get_user_membership( $user_id );

    ob_start();
    ?>
    <div class="ninja-member-dashboard">
        <section class="membership-status">
            <h2><?php esc_html_e( 'Tu membresía', 'ninja-membership' ); ?></h2>
            <?php if ( $membership ) : ?>
                <dl>
                    <dt><?php esc_html_e( 'Plan', 'ninja-membership' ); ?></dt>
                    <dd><?php echo esc_html( $membership['plan_name'] ); ?></dd>
                    <dt><?php esc_html_e( 'Estado', 'ninja-membership' ); ?></dt>
                    <dd class="status-<?php echo esc_attr( $membership['status'] ); ?>">
                        <?php echo esc_html( $membership['status_label'] ); ?>
                    </dd>
                    <dt><?php esc_html_e( 'Próxima renovación', 'ninja-membership' ); ?></dt>
                    <dd><?php echo esc_html( wp_date( 'd/m/Y', $membership['expires'] ) ); ?></dd>
                </dl>
                <a href="<?php echo esc_url( ninja_get_billing_portal_url( $user_id ) ); ?>" class="button">
                    <?php esc_html_e( 'Gestionar suscripción', 'ninja-membership' ); ?>
                </a>
            <?php else : ?>
                <p><?php esc_html_e( 'No tienes una membresía activa.', 'ninja-membership' ); ?></p>
                <a href="<?php echo esc_url( ninja_get_plans_page_url() ); ?>" class="button button-primary">
                    <?php esc_html_e( 'Ver planes', 'ninja-membership' ); ?>
                </a>
            <?php endif; ?>
        </section>
    </div>
    <?php
    return ob_get_clean();
} );
