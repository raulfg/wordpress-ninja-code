// ¿Tiene el usuario acceso a un curso concreto?
$has_access = sfwd_lms_has_access( $course_id, $user_id );

// Obtener el progreso del usuario en un curso (0-100)
$progress = learndash_course_progress( [
    'user_id'   => $user_id,
    'course_id' => $course_id,
    'array'     => true, // devuelve array con 'completed', 'total', 'percentage'
] );

// ¿Ha completado el usuario el curso?
$completed = learndash_is_course_complete( $user_id, $course_id );

// Fecha desde la que el usuario tiene acceso al curso
$access_from = ld_course_access_from( $course_id, $user_id );
// Devuelve un timestamp Unix o false si no tiene acceso

// Obtener todas las lecciones de un curso
$lessons = learndash_get_course_lessons_list( $course_id );
