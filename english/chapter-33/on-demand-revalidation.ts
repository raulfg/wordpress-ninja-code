// pages/api/revalidate.ts

import type { NextApiRequest, NextApiResponse } from 'next';

export default async function handler( req: NextApiRequest, res: NextApiResponse ) {
    // Verify the secret token to prevent unauthorized requests
    if ( req.query.secret !== process.env.REVALIDATION_SECRET ) {
        return res.status( 401 ).json( { message: 'Invalid token' } );
    }

    const { path } = req.body;

    if ( ! path ) {
        return res.status( 400 ).json( { message: 'path is required' } );
    }

    try {
        await res.revalidate( path );
        return res.json( { revalidated: true } );
    } catch ( err ) {
        return res.status( 500 ).json( { message: 'Error revalidating' } );
    }
}
