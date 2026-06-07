if ( have_rows( 'project_milestones' ) ) {
    echo '<ol class="milestones">';

    while ( have_rows( 'project_milestones' ) ) {
        the_row();

        $title = get_sub_field( 'milestone_title' );
        $date  = get_sub_field( 'milestone_date' );

        printf(
            '<li><strong>%s</strong> — %s</li>',
            esc_html( $title ),
            esc_html( $date )
        );
    }

    echo '</ol>';
}
