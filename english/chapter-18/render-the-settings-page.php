public function render_page(): void
{
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $options = get_option( 'npe_settings', [] );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'npe_settings_group' );
            do_settings_sections( 'npe-settings' );
            submit_button( __( 'Save changes', 'ninja-portfolio-enhancer' ) );
            ?>
        </form>
    </div>
    <?php
}
