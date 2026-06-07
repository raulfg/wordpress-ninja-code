// Check if a user passed a quiz with a sufficient score
function ninja_user_passed_quiz( int $user_id, int $quiz_id, float $min_score = 70.0 ): bool {
    $activity = learndash_get_user_activity( [
        'user_id'       => $user_id,
        'post_id'       => $quiz_id,
        'activity_type' => 'quiz',
        'activity_status' => true, // completed only
    ] );

    if ( empty( $activity ) ) {
        return false;
    }

    $best_score = 0;
    foreach ( $activity as $attempt ) {
        $score = (float) $attempt->activity_meta['percentage'] ?? 0;
        $best_score = max( $best_score, $score );
    }

    return $best_score >= $min_score;
}
