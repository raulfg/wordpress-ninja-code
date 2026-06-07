<?php

// In the plugin bootstrap
require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\RetryMiddleware;

class NinjaAPIClient {
    private Client $client;

    public function __construct() {
        $stack = HandlerStack::create();

        // Automatic retry middleware
        $stack->push( Middleware::retry(
            function( int $retries, $request, $response = null, $exception = null ): bool {
                if ( $retries >= 3 ) {
                    return false;
                }
                // Retry on network errors or 5xx responses
                if ( $exception instanceof \Exception ) {
                    return true;
                }
                if ( $response && $response->getStatusCode() >= 500 ) {
                    return true;
                }
                return false;
            },
            function( int $retries ): int {
                // Exponential backoff: 1s, 2s, 4s
                return (int) pow( 2, $retries ) * 1000;
            }
        ) );

        $this->client = new Client( [
            'base_uri' => 'https://api.service.com/',
            'timeout'  => 10,
            'handler'  => $stack,
            'headers'  => [
                'Authorization' => 'Bearer ' . get_option( 'ninja_api_token' ),
                'Accept'        => 'application/json',
            ],
        ] );
    }

    public function get_items( int $page = 1, int $per_page = 20 ): array {
        try {
            $response = $this->client->get( 'items', [
                'query' => [ 'page' => $page, 'per_page' => $per_page ],
            ] );

            return json_decode( (string) $response->getBody(), true ) ?? [];

        } catch ( \GuzzleHttp\Exception\ClientException $e ) {
            // 4xx errors: client-side issue (bad request, auth, not found)
            $status = $e->getResponse()->getStatusCode();
            error_log( "API client error {$status}: " . $e->getMessage() );
            return [];

        } catch ( \GuzzleHttp\Exception\ServerException $e ) {
            // 5xx errors: remote server issue
            error_log( 'API server error: ' . $e->getMessage() );
            return [];

        } catch ( \GuzzleHttp\Exception\ConnectException $e ) {
            // Connection error (timeout, DNS, etc.)
            error_log( 'API connection error: ' . $e->getMessage() );
            return [];
        }
    }
}
