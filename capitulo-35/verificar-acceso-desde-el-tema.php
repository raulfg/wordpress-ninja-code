// En single-course.php o en el bloque Portfolio del tema
$course_id   = get_the_ID();
$user_id     = get_current_user_id();
$is_enrolled = $user_id ? llms_is_user_enrolled( $user_id, $course_id ) : false;

if ( $is_enrolled ) {
    // Mostrar el botón «Continuar curso» con el progreso actual
    $progress = llms_get_user_postmeta( $user_id, $course_id, '_overall_progress' );
    printf(
        '<a href="%s">%s — %d%%</a>',
        esc_url( llms_get_next_incomplete_lesson_url( $course_id, $user_id ) ),
        esc_html__( 'Continuar', 'ninjatheme' ),
        absint( $progress )
    );
} else {
    // Mostrar el botón de compra gestionado por MemberPress o LifterLMS
    echo llms_get_enrollment_trigger_text( $course_id );
}
