<?php

// Contact Form 7 compatibility
add_action( 'wpcf7_mail_sent', function( \WPCF7_ContactForm $form ): void {
    // Only process the portfolio contact form
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
        'firstname' => $data['name'] ?? '',
        'phone'     => $data['phone'] ?? '',
        'message'   => $data['message'] ?? '',
    ] );

    if ( is_wp_error( $contact_id ) ) {
        error_log( '[ninja-portfolio] Could not create contact: ' . $contact_id->get_error_message() );
        return;
    }

    // Add a note with the original message
    $crm->add_note(
        $contact_id,
        sprintf(
            "Contact from the portfolio website.\n\nMessage:\n%s",
            $data['message'] ?? ''
        )
    );

    // Store the HubSpot ID in user meta if the user is registered
    $user = get_user_by( 'email', $data['email'] ?? '' );
    if ( $user ) {
        update_user_meta( $user->ID, '_hubspot_contact_id', $contact_id );
    }
} );
