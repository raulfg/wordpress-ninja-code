// Create an Application Password for the current user
[ $password, $item ] = WP_Application_Passwords::create_new_application_password(
    get_current_user_id(),
    [ 'name' => 'Pipeline CI/CD' ]
);
// $password is the plaintext password: only available at this moment.
// $item is the metadata array: uuid, name, created, last_used, last_ip.

// List all Application Passwords for a user
$passwords = WP_Application_Passwords::get_user_application_passwords( $user_id );

// Revoke an Application Password by UUID
WP_Application_Passwords::delete_application_password( $user_id, $item['uuid'] );

// Revoke all passwords for a user
WP_Application_Passwords::delete_all_application_passwords( $user_id );
