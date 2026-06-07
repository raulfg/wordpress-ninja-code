// pages/api/revalidate.ts

import type { NextApiRequest, NextApiResponse } from 'next';

export default async function handler( req: NextApiRequest, res: NextApiResponse ) {
    // Verificar el token secreto para evitar peticiones no autorizadas
    if ( req.query.secret !== process.env.REVALIDATION_SECRET ) {
        return res.status( 401 ).json( { message: 'Token inválido' } );
    }

    const { path } = req.body;

    if ( ! path ) {
        return res.status( 400 ).json( { message: 'path es requerido' } );
    }

    try {
        await res.revalidate( path );
        return res.json( { revalidated: true } );
    } catch ( err ) {
        return res.status( 500 ).json( { message: 'Error al revalidar' } );
    }
}
