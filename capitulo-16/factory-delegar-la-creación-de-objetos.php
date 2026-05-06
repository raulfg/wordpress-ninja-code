<?php
declare(strict_types=1);

namespace NinjaTheme\Widgets;

interface WidgetInterface
{
    public function render( array $instance ): void;
}

class TextWidget implements WidgetInterface
{
    public function __construct( private readonly array $config = [] ) {}

    public function render( array $instance ): void
    {
        echo esc_html( $instance['content'] ?? '' );
    }
}

class ImageWidget implements WidgetInterface
{
    public function __construct( private readonly array $config = [] ) {}

    public function render( array $instance ): void
    {
        $url = esc_url( $instance['image_url'] ?? '' );
        echo "<img src=\"{$url}\" alt=\"\" />";
    }
}

class WidgetFactory
{
    /**
     * Crea el widget correcto según el tipo indicado.
     *
     * @throws \InvalidArgumentException Si el tipo no está soportado.
     */
    public static function create( string $type, array $config = [] ): WidgetInterface
    {
        return match ( $type ) {
            'text'  => new TextWidget( $config ),
            'image' => new ImageWidget( $config ),
            default => throw new \InvalidArgumentException(
                "Tipo de widget no soportado: {$type}"
            ),
        };
    }
}
