<?php
declare(strict_types=1);

namespace NinjaTheme\DI;

class Container
{
    /** @var array<string, callable> */
    private array $bindings = [];

    /** @var array<string, object> */
    private array $singletons = [];

    /**
     * Registra una factory para una clase.
     *
     * @param string   $id      Identificador (normalmente la FQCN o una interfaz)
     * @param callable $factory Callable que devuelve la instancia
     */
    public function bind( string $id, callable $factory ): void
    {
        $this->bindings[ $id ] = $factory;
    }

    /**
     * Registra una factory que siempre devuelve la misma instancia.
     */
    public function singleton( string $id, callable $factory ): void
    {
        $this->bindings[ $id ] = function () use ( $id, $factory ) {
            if ( ! isset( $this->singletons[ $id ] ) ) {
                $this->singletons[ $id ] = $factory( $this );
            }
            return $this->singletons[ $id ];
        };
    }

    /**
     * Resuelve y devuelve el objeto asociado al ID.
     *
     * @throws \RuntimeException Si el ID no está registrado.
     */
    public function get( string $id ): mixed
    {
        if ( ! isset( $this->bindings[ $id ] ) ) {
            throw new \RuntimeException( "No hay binding para: {$id}" );
        }

        return ( $this->bindings[ $id ] )( $this );
    }
}
