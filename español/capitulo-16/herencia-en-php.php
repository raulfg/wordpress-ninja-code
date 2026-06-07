<?php

namespace NinjaTheme\PostTypes;

abstract class AbstractPostType
{
    abstract protected function get_post_type(): string;
    abstract protected function get_args(): array;

    public function __construct()
    {
        add_action( 'init', [ $this, 'register' ] );
    }

    public function register(): void
    {
        register_post_type( $this->get_post_type(), $this->get_args() );
    }
}
