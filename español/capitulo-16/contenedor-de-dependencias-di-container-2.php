<?php
// src/bootstrap.php

use NinjaTheme\DI\Container;
use NinjaTheme\Assets;
use NinjaTheme\PostTypes\Portfolio;
use NinjaTheme\Cache\TransientCache;
use NinjaTheme\API\PortfolioEndpoint;
use NinjaTheme\Theme;

$container = new Container();

$container->singleton( TransientCache::class, fn( Container $c ) =>
    new TransientCache( 'ninjatheme_', 3600 )
);

$container->singleton( Portfolio::class, fn( Container $c ) =>
    new Portfolio( $c->get( TransientCache::class ) )
);

$container->singleton( Assets::class, fn( Container $c ) =>
    new Assets( get_template_directory_uri() )
);

$container->singleton( PortfolioEndpoint::class, fn( Container $c ) =>
    new PortfolioEndpoint( $c->get( Portfolio::class ) )
);

$container->singleton( Theme::class, fn( Container $c ) =>
    new Theme(
        $c->get( Assets::class ),
        $c->get( Portfolio::class ),
        $c->get( PortfolioEndpoint::class )
    )
);

return $container;
