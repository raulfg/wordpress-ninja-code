// src/portfolio-card/test/edit.test.js

import { render, screen } from '@testing-library/react';
import userEvent from '@testing-library/user-event';
import Edit from '../edit';

const defaultProps = {
    attributes: {
        title: '',
        showClient: true,
        count: 3,
    },
    setAttributes: jest.fn(),
};

describe( 'Portfolio Card Edit', () => {
    it( 'renders the count control', () => {
        render( <Edit { ...defaultProps } /> );
        expect( screen.getByLabelText( /number of projects/i ) ).toBeInTheDocument();
    } );

    it( 'calls setAttributes when count changes', async () => {
        render( <Edit { ...defaultProps } /> );
        const input = screen.getByLabelText( /number of projects/i );

        await userEvent.clear( input );
        await userEvent.type( input, '6' );

        expect( defaultProps.setAttributes ).toHaveBeenCalledWith(
            expect.objectContaining( { count: 6 } )
        );
    } );
} );
