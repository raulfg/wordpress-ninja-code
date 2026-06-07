/**
 * Get published courses at the "premium" tier of NinjaTheme Academy.
 * Courses at this tier have the meta 'ninja_academy_tier' = 'premium'.
 */
function ninjatheme_get_premium_courses(): array {
    $query = new WP_Query( [
        'post_type'      => 'course',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_key'       => 'ninja_academy_tier',
        'meta_value'     => 'premium',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ] );

    $courses = [];

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();

            $course_id = get_the_ID();

            $courses[] = [
                'id'           => $course_id,
                'title'        => get_the_title(),
                'permalink'    => get_permalink(),
                'thumbnail'    => get_the_post_thumbnail_url( $course_id, 'medium' ),
                'lesson_count' => llms_get_post( $course_id )->get_lessons_count(),
                'enrolled'     => llms_is_user_enrolled( get_current_user_id(), $course_id ),
            ];
        }

        wp_reset_postdata();
    }

    return $courses;
}
