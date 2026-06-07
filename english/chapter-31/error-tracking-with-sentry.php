<?php
// mu-plugins/sentry.php

use Sentry\State\Scope;

\Sentry\init([
    'dsn'                => 'https://your-key@sentry.io/project-id',
    'environment'        => wp_get_environment_type(),
    'release'            => '1.0.0',
    'traces_sample_rate' => 0.1, // 10% of transactions for performance monitoring
]);

// Add context for the authenticated user
add_action('init', function () {
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        \Sentry\configureScope(function (Scope $scope) use ($user): void {
            $scope->setUser([
                'id'    => $user->ID,
                'email' => $user->user_email,
            ]);
        });
    }
});
