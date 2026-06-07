<?php
declare(strict_types=1);

namespace NinjaPlugin\Payments;

class GatewayRegistry
{
    /** @var array<string, callable(): GatewayInterface> */
    private array $factories = [];

    private static ?GatewayRegistry $instance = null;

    private function __construct() {}

    public static function get_instance(): GatewayRegistry
    {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Registers a factory for a payment gateway.
     *
     * @param string   $id      Unique identifier ('stripe', 'paypal', etc.)
     * @param callable $factory Callable that returns an instance of GatewayInterface
     */
    public function register( string $id, callable $factory ): void
    {
        $this->factories[ $id ] = $factory;
    }

    /**
     * Returns the requested gateway.
     *
     * @throws \RuntimeException If the gateway is not registered.
     */
    public function get( string $id ): GatewayInterface
    {
        if ( ! isset( $this->factories[ $id ] ) ) {
            throw new \RuntimeException( "Gateway not registered: {$id}" );
        }

        return ( $this->factories[ $id ] )();
    }

    /**
     * Returns all registered gateway IDs.
     *
     * @return string[]
     */
    public function get_registered_ids(): array
    {
        return array_keys( $this->factories );
    }
}
