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
        revalidate: 3600, // Regenerate at most once per hour
    };
}

export async function getStaticPaths() {
    // Pre-render only the most recent projects at build time
    const response = await fetch(
        `${process.env.NEXT_PUBLIC_WP_API}/wp/v2/portfolio?per_page=20&orderby=date&order=desc`
    );
    const projects = await response.json();

    return {
        paths: projects.map( ( p: { slug: string } ) => ( {
            params: { slug: p.slug },
        } ) ),
        fallback: 'blocking', // The rest is generated on first access
    };
}
