// lib/wordpress.ts

const WP_API = process.env.NEXT_PUBLIC_WP_API_URL;

if ( ! WP_API ) {
  throw new Error( 'NEXT_PUBLIC_WP_API_URL no está definida' );
}

export async function getPosts( perPage = 10 ): Promise<WPPost[]> {
  const fields = 'id,date,slug,title,excerpt';
  const url = `${WP_API}/wp/v2/posts?_fields=${fields}&per_page=${perPage}`;

  const res = await fetch( url, {
    next: { revalidate: 3600 }, // ISR: revalidar cada hora
  } );

  if ( ! res.ok ) {
    throw new Error( `Error al obtener posts: ${res.status}` );
  }

  return res.json();
}

export async function getPostBySlug( slug: string ): Promise<WPPost | null> {
  const url = `${WP_API}/wp/v2/posts?slug=${slug}&_fields=id,date,slug,title,content,yoast_head_json`;

  const res = await fetch( url, {
    next: { revalidate: 3600 },
  } );

  if ( ! res.ok ) {
    return null;
  }

  const posts: WPPost[] = await res.json();
  return posts[0] ?? null;
}

export async function getAllSlugs(): Promise<string[]> {
  const url = `${WP_API}/wp/v2/posts?_fields=slug&per_page=100`;

  const res = await fetch( url, {
    cache: 'no-store', // Los slugs cambian — no cachear en producción sin ISR explícito
  } );

  if ( ! res.ok ) {
    return [];
  }

  const posts: Pick<WPPost, 'slug'>[] = await res.json();
  return posts.map( ( p ) => p.slug );
}
