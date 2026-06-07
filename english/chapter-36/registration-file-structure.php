<?php
declare(strict_types=1);

namespace NinjaPortfolio\Abilities;

class PortfolioAbilities {

    public function register(): void {
        add_action( 'wp_abilities_api_categories_init', [ $this, 'register_category' ] );
        add_action( 'wp_abilities_api_init', [ $this, 'register_all' ] );
    }

    public function register_category(): void {
        wp_register_ability_category( 'ninja-portfolio', [
            'label'       => __( 'Portfolio', 'ninja-portfolio' ),
            'description' => __( 'Management of the NinjaTheme project portfolio.', 'ninja-portfolio' ),
        ] );
    }

    public function register_all(): void {
        $this->register_get_projects();
        $this->register_get_project();
        $this->register_create_project();
        $this->register_update_project();
        $this->register_delete_project();
        $this->register_get_stats();
    }
