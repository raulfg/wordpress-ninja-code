export async function getStaticProps( context: GetStaticPropsContext ) {
    const { slug } = context.params as { slug: string };
    const { preview, previewData } = context;

    let post;

    if ( preview && previewData ) {
        // En modo preview: obtener el borrador con autenticación
        const { id } = previewData as { id: number; type: string };
        const response = await fetch(
            `${process.env.WP_API_URL}/wp/v2/posts/${id}?_embed`,
            {
                headers: {
                    Authorization: 'Basic ' + Buffer.from(
                        `${process.env.WP_USER}:${process.env.WP_APP_PASSWORD}`
                    ).toString( 'base64' ),
                },
            }
        );
        post = await response.json();
    } else {
        // En modo normal: obtener el post publicado sin autenticación
        const response = await fetch(
            `${process.env.WP_API_URL}/wp/v2/posts?slug=${slug}&_embed`
        );
        [post] = await response.json();
    }

    return { props: { post }, revalidate: 3600 };
}
