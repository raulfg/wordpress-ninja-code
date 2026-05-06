// pages/api/preview.ts

export default async function handler( req: NextApiRequest, res: NextApiResponse ) {
    const { secret, id, type } = req.query;

    if ( secret !== process.env.PREVIEW_SECRET ) {
        return res.status( 401 ).json( { message: 'Token inválido' } );
    }

    // Verificar que el post existe en WordPress
    const wpResponse = await fetch(
        `${process.env.WP_API_URL}/wp/v2/${type}s/${id}?status=draft`,
        {
            headers: {
                Authorization: 'Basic ' + Buffer.from(
                    `${process.env.WP_USER}:${process.env.WP_APP_PASSWORD}`
                ).toString( 'base64' ),
            },
        }
    );

    if ( ! wpResponse.ok ) {
        return res.status( 404 ).json( { message: 'Post no encontrado' } );
    }

    const post = await wpResponse.json();

    // Activar Preview Mode con los datos del post
    res.setPreviewData( { id: post.id, type } );

    res.redirect( `/blog/${post.slug}` );
}
