// app/api/revalidate/route.ts
import { revalidatePath, revalidateTag } from 'next/cache';
import { NextRequest, NextResponse } from 'next/server';

export async function POST( request: NextRequest ) {
  const secret = request.nextUrl.searchParams.get( 'secret' );

  if ( secret !== process.env.REVALIDATION_SECRET ) {
    return NextResponse.json( { message: 'Invalid secret' }, { status: 401 } );
  }

  const { path, tag } = await request.json();

  if ( tag ) {
    revalidateTag( tag );
  } else if ( path ) {
    revalidatePath( path );
  }

  return NextResponse.json( { revalidated: true } );
}
