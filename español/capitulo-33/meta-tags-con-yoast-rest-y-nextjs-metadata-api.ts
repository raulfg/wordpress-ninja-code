// app/portfolio/[slug]/page.tsx

import type { Metadata } from 'next';

interface PortfolioPost {
    id: number;
    slug: string;
    title: { rendered: string };
    yoast_head_json: {
        title: string;
        description: string;
        og_image?: Array<{ url: string; width: number; height: number }>;
        schema: object;
    };
}

async function getPortfolioPost( slug: string ): Promise<PortfolioPost | null> {
    const response = await fetch(
        `${process.env.WORDPRESS_API_URL}/wp/v2/portfolio?slug=${slug}&_embed`,
        { next: { revalidate: 3600 } }
    );

    if ( ! response.ok ) return null;

    const posts = await response.json();
    return posts[0] ?? null;
}

export async function generateMetadata(
    { params }: { params: { slug: string } }
): Promise<Metadata> {
    const post = await getPortfolioPost( params.slug );

    if ( ! post ) {
        return { title: 'Proyecto no encontrado' };
    }

    const seo = post.yoast_head_json;

    return {
        title:       seo.title,
        description: seo.description,
        openGraph: {
            title:  seo.og_title ?? seo.title,
            description: seo.description,
            images: seo.og_image?.map( img => ( {
                url:    img.url,
                width:  img.width,
                height: img.height,
            } ) ) ?? [],
        },
    };
}
