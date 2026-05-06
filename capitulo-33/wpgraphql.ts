// lib/graphql.ts

const GRAPHQL_URL = process.env.NEXT_PUBLIC_WP_GRAPHQL_URL ?? '';

interface GraphQLResponse<T> {
  data: T;
  errors?: { message: string }[];
}

export async function wpQuery<T>(
  query: string,
  variables: Record<string, unknown> = {},
  options: RequestInit = {}
): Promise<T> {
  const res = await fetch( GRAPHQL_URL, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      ...( options.headers as Record<string, string> ?? {} ),
    },
    body: JSON.stringify( { query, variables } ),
    ...options,
  } );

  const json: GraphQLResponse<T> = await res.json();

  if ( json.errors?.length ) {
    throw new Error( json.errors[0].message );
  }

  return json.data;
}
