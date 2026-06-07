<?php
/**
 * Plugin Name: Ninja Portfolio Enhancer
 * Plugin URI:  https://github.com/raulfg/ninja-portfolio-enhancer
 * Description: CPT, taxonomies, ACF fields and REST endpoints for a professional portfolio.
 * Version:     1.0.0
 * Requires PHP: 8.1
 * Text Domain: ninja-portfolio
 */

declare(strict_types=1);

namespace NinjaPortfolio;

if (! defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

add_action('plugins_loaded', static function (): void {
    new PostTypes\PortfolioCpt();
    new Taxonomies\PortfolioCategory();
    new Taxonomies\PortfolioTag();
    new Fields\AcfGroups();
    new Api\PortfolioEndpoints();
    new Blocks\BlockRegistrar();
});
