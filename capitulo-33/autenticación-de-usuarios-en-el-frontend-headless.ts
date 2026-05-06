// app/api/auth/login/route.ts

import { cookies } from 'next/headers';

export async function POST( request: Request ) {
  const { username, password } = await request.json();

  const res = await fetch(
    `${process.env.NEXT_PUBLIC_WP_API_URL}/jwt-auth/v1/token`,
    {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify( { username, password } ),
    }
  );

  if ( ! res.ok ) {
    return new Response( 'Credenciales no válidas', { status: 401 } );
  }

  const { token } = await res.json();

  cookies().set( 'wp_token', token, {
    httpOnly: true,
    secure: process.env.NODE_ENV === 'production',
    sameSite: 'lax',
    maxAge: 60 * 60, // 1 hora
    path: '/',
  } );

  return new Response( 'OK', { status: 200 } );
}
