// In the cart block's view.js
import { store, getContext } from '@wordpress/interactivity';

const { state, actions } = store( 'mi-tienda/carrito', {
    state: {
        get totalItems() {
            return state.items.reduce( ( sum, item ) => sum + item.cantidad, 0 );
        },
        items: [],
    },
    actions: {
        async añadir( productoId ) {
            const context = getContext();
            // REST API call to add to cart
            const response = await fetch( `/wp-json/mi-tienda/v1/carrito/${productoId}`, {
                method: 'POST',
            } );
            const data = await response.json();
            state.items = data.items;
        },
    },
} );
