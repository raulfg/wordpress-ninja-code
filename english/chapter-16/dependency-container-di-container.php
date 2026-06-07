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
     * Registers a factory for a class.
     *
     * @param string   $id      Identifier (usually the FQCN or an interface)
     * @param callable $factory Callable that returns the instance
     */
    public function bind( string $id, callable $factory ): void
    {
        $this->bindings[ $id ] = $factory;
    }

    /**
     * Registers a factory that always returns the same instance.
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
     * Resolves and returns the object associated with the ID.
     *
     * @throws \RuntimeException If the ID is not registered.
     */
    public function get( string $id ): mixed
    {
        if ( ! isset( $this->bindings[ $id ] ) ) {
            throw new \RuntimeException( "No binding for: {$id}" );
        }

        return ( $this->bindings[ $id ] )( $this );
    }
}
