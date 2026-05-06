// Crear una Application Password para el usuario actual
[ $password, $item ] = WP_Application_Passwords::create_new_application_password(
    get_current_user_id(),
    [ 'name' => 'Pipeline CI/CD' ]
);
// $password es la contraseña en texto plano: solo está disponible en este momento.
// $item es el array de metadatos: uuid, name, created, last_used, last_ip.

// Listar todas las Application Passwords de un usuario
$passwords = WP_Application_Passwords::get_user_application_passwords( $user_id );

// Revocar una Application Password por UUID
WP_Application_Passwords::delete_application_password( $user_id, $item['uuid'] );

// Revocar todas las contraseñas de un usuario
WP_Application_Passwords::delete_all_application_passwords( $user_id );
