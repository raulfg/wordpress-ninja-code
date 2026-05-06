<?php
/**
 * footer.php — NinjaTheme
 */
?>

<footer id="site-footer" class="site-footer">
    <div class="footer-content">
        <nav aria-label="<?php esc_attr_e( 'Menú de pie de página', 'ninjatheme' ); ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'footer',
                'depth'          => 1,
                'container'      => false,
                'fallback_cb'    => false,
            ] );
            ?>
        </nav>

        <p class="copyright">
            &copy; <?php echo esc_html( date( 'Y' ) ); ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php bloginfo( 'name' ); ?>
            </a>
        </p>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
