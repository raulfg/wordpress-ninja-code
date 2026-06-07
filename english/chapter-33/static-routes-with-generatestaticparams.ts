// app/posts/[slug]/page.tsx

import { getAllSlugs, getPostBySlug } from '@/lib/wordpress';
import { notFound } from 'next/navigation';
import type { Metadata } from 'next';
import type { WPPost } from '@/types/wordpress';

export async function generateStaticParams() {
  const slugs = await getAllSlugs();
  return slugs.map( ( slug ) => ( { slug } ) );
}

export async function generateMetadata(
  { params }: { params: { slug: string } }
): Promise<Metadata> {
  const post = await getPostBySlug( params.slug );

  if ( ! post ) {
    return { title: 'Post not found' };
  }

  const seo = post.yoast_head_json;

  return {
    title: seo?.title ?? post.title.rendered,
    description: seo?.description,
    openGraph: {
      images: seo?.og_image?.map( ( img ) => img.url ) ?? [],
    },
  };
}

export default async function PostPage(
  { params }: { params: { slug: string } }
) {
  const post = await getPostBySlug( params.slug );

  if ( ! post ) {
    notFound();
  }

  return (
    <article>
      <h1 dangerouslySetInnerHTML={{ __html: post.title.rendered }} />
      <time dateTime={post.date}>
        {new Date( post.date ).toLocaleDateString( 'es-ES' )}
      </time>
      <div dangerouslySetInnerHTML={{ __html: post.content.rendered }} />
    </article>
  );
}
