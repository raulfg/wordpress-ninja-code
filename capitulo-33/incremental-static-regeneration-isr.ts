// pages/portfolio/[slug].tsx

export async function getStaticProps( context: GetStaticPropsContext ) {
    const { slug } = context.params as { slug: string };

    const response = await fetch(
        `${process.env.NEXT_PUBLIC_WP_API}/wp/v2/portfolio?slug=${slug}&_embed`
    );

    if ( ! response.ok ) {
        return { notFound: true };
    }

    const [project] = await response.json();

    if ( ! project ) {
        return { notFound: true };
    }

    return {
        props: {
            project,
        },
        revalidate: 3600, // Regenerar cada hora como máximo
    };
}

export async function getStaticPaths() {
    // Prerenderizar solo los proyectos más recientes en build time
    const response = await fetch(
        `${process.env.NEXT_PUBLIC_WP_API}/wp/v2/portfolio?per_page=20&orderby=date&order=desc`
    );
    const projects = await response.json();

    return {
        paths: projects.map( ( p: { slug: string } ) => ( {
            params: { slug: p.slug },
        } ) ),
        fallback: 'blocking', // El resto se genera en el primer acceso
    };
}
