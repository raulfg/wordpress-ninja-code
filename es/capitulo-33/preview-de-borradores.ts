// app/api/preview/route.ts

import { draftMode } from 'next/headers';
import { redirect } from 'next/navigation';

const WP_API = process.env.NEXT_PUBLIC_WP_API_URL ?? '';
const PREVIEW_SECRET = process.env.PREVIEW_SECRET ?? '';

export async function GET( request: Request ) {
  const { searchParams } = new URL( request.url );
  const secret = searchParams.get( 'secret' );
  const slug   = searchParams.get( 'slug' );

  if ( secret !== PREVIEW_SECRET || ! slug ) {
    return new Response( 'Token no válido', { status: 401 } );
  }

  const res = await fetch(
    `${WP_API}/wp/v2/posts?slug=${slug}&status=draft&_fields=slug`,
    {
      headers: {
        Authorization: `Basic ${Buffer.from(
          `${process.env.WP_USER}:${process.env.WP_APP_PASSWORD}`
        ).toString( 'base64' )}`,
      },
    }
  );

  if ( ! res.ok ) {
    return new Response( 'Post no encontrado', { status: 404 } );
  }

  draftMode().enable();
  redirect( `/posts/${slug}` );
}
