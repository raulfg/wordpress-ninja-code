// src/Integrations/HubSpotCRM.php

namespace NinjaPortfolio\Integrations;

class HubSpotCRM {

    private string $api_key;
    private string $base_url = 'https://api.hubapi.com/crm/v3';

    public function __construct() {
        $this->api_key = get_option( 'ninja_hubspot_api_key', '' );
    }

    /**
     * Crea o actualiza un contacto en HubSpot.
     *
     * @param array $data  Datos del contacto: email, firstname, lastname, phone, message.
     * @return int|WP_Error ID del contacto en HubSpot o error.
     */
    public function upsert_contact( array $data ): int|\WP_Error {
        if ( empty( $this->api_key ) ) {
            return new \WP_Error( 'no_api_key', 'HubSpot API key no configurada.' );
        }

        $properties = array_filter( [
            'email'     => sanitize_email( $data['email'] ?? '' ),
            'firstname' => sanitize_text_field( $data['firstname'] ?? '' ),
            'lastname'  => sanitize_text_field( $data['lastname'] ?? '' ),
            'phone'     => sanitize_text_field( $data['phone'] ?? '' ),
            'message'   => sanitize_textarea_field( $data['message'] ?? '' ),
        ] );

        if ( empty( $properties['email'] ) ) {
            return new \WP_Error( 'invalid_email', 'Email requerido para crear el contacto.' );
        }

        $response = wp_remote_post(
            $this->base_url . '/objects/contacts',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->api_key,
                    'Content-Type'  => 'application/json',
                ],
                'body'    => wp_json_encode( [ 'properties' => $properties ] ),
                'timeout' => 15,
            ]
        );

        if ( is_wp_error( $response ) ) {
            error_log( '[ninja-portfolio] HubSpot connection error: ' . $response->get_error_message() );
            return $response;
        }

        $code = wp_remote_retrieve_response_code( $response );
        $body = json_decode( wp_remote_retrieve_body( $response ), true );

        // 409 = contacto ya existe; recuperar el ID existente
        if ( 409 === $code ) {
            return $this->get_contact_id_by_email( $properties['email'] );
        }

        if ( $code < 200 || $code >= 300 ) {
            $message = $body['message'] ?? 'Error desconocido de HubSpot';
            error_log( "[ninja-portfolio] HubSpot error {$code}: {$message}" );
            return new \WP_Error( 'hubspot_error', $message, [ 'status' => $code ] );
        }

        return (int) $body['id'];
    }

    /**
     * Obtiene el ID de un contacto existente por email.
     */
    private function get_contact_id_by_email( string $email ): int|\WP_Error {
        $response = wp_remote_get(
            $this->base_url . '/objects/contacts/' . urlencode( $email ) . '?idProperty=email',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->api_key,
                ],
                'timeout' => 10,
            ]
        );

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $body = json_decode( wp_remote_retrieve_body( $response ), true );
        return isset( $body['id'] ) ? (int) $body['id'] : new \WP_Error( 'not_found', 'Contacto no encontrado.' );
    }

    /**
     * Crea una nota asociada a un contacto.
     */
    public function add_note( int $contact_id, string $content ): bool {
        $response = wp_remote_post(
            $this->base_url . '/objects/notes',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->api_key,
                    'Content-Type'  => 'application/json',
                ],
                'body' => wp_json_encode( [
                    'properties' => [
                        'hs_note_body'           => sanitize_textarea_field( $content ),
                        'hs_timestamp'           => (string) ( time() * 1000 ),
                        'hubspot_owner_id'       => get_option( 'ninja_hubspot_owner_id', '' ),
                    ],
                    'associations' => [
                        [
                            'to'    => [ 'id' => $contact_id ],
                            'types' => [
                                [
                                    'associationCategory' => 'HUBSPOT_DEFINED',
                                    'associationTypeId'   => 202, // nota → contacto
                                ],
                            ],
                        ],
                    ],
                ] ),
                'timeout' => 15,
            ]
        );

        return ! is_wp_error( $response )
            && wp_remote_retrieve_response_code( $response ) === 201;
    }
}
