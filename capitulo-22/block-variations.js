import { registerBlockVariation } from '@wordpress/blocks';

registerBlockVariation( 'core/columns', {
    name:        'ninjatheme/portfolio-layout',
    title:       'Layout Portfolio',
    description: 'Tres columnas para ficha de proyecto.',
    isDefault:   false,
    scope:       [ 'inserter' ],
    attributes: {
        columns: 3,
        isStackedOnMobile: true,
    },
    innerBlocks: [
        [ 'core/column', {}, [] ],
        [ 'core/column', {}, [] ],
        [ 'core/column', {}, [] ],
    ],
} );
