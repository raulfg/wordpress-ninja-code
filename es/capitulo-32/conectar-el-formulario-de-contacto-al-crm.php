// Compatibilidad con Contact Form 7
add_action( 'wpcf7_mail_sent', function( \WPCF7_ContactForm $form ): void {
    // Solo procesar el formulario de contacto del portfolio
    if ( 'ninja-portfolio-contact' !== $form->name() ) {
        return;
    }

    $submission = \WPCF7_Submission::get_instance();
    if ( ! $submission ) {
        return;
    }

    $data = $submission->get_posted_data();
    $crm  = new \NinjaPortfolio\Integrations\HubSpotCRM();

    $contact_id = $crm->upsert_contact( [
        'email'     => $data['email'] ?? '',
        'firstname' => $data['nombre'] ?? '',
        'phone'     => $data['telefono'] ?? '',
        'message'   => $data['mensaje'] ?? '',
    ] );

    if ( is_wp_error( $contact_id ) ) {
        error_log( '[ninja-portfolio] No se pudo crear el contacto: ' . $contact_id->get_error_message() );
        return;
    }

    // Añadir una nota con el mensaje original
    $crm->add_note(
        $contact_id,
        sprintf(
            "Contacto desde el portfolio web.\n\nMensaje:\n%s",
            $data['mensaje'] ?? ''
        )
    );

    // Guardar el ID de HubSpot en user meta si el usuario está registrado
    $user = get_user_by( 'email', $data['email'] ?? '' );
    if ( $user ) {
        update_user_meta( $user->ID, '_hubspot_contact_id', $contact_id );
    }
} );
