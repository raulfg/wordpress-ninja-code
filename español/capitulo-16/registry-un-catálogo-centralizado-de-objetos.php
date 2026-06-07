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
     * Registra una factory para una pasarela de pago.
     *
     * @param string   $id      Identificador único ('stripe', 'paypal', etc.)
     * @param callable $factory Callable que devuelve una instancia de GatewayInterface
     */
    public function register( string $id, callable $factory ): void
    {
        $this->factories[ $id ] = $factory;
    }

    /**
     * Devuelve la pasarela solicitada.
     *
     * @throws \RuntimeException Si la pasarela no está registrada.
     */
    public function get( string $id ): GatewayInterface
    {
        if ( ! isset( $this->factories[ $id ] ) ) {
            throw new \RuntimeException( "Pasarela no registrada: {$id}" );
        }

        return ( $this->factories[ $id ] )();
    }

    /**
     * Devuelve todos los IDs de pasarelas registradas.
     *
     * @return string[]
     */
    public function get_registered_ids(): array
    {
        return array_keys( $this->factories );
    }
}
