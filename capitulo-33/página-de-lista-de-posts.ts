// app/page.tsx

import { getPosts } from '@/lib/wordpress';
import type { WPPost } from '@/types/wordpress';

export default async function HomePage() {
  const posts = await getPosts( 10 );

  return (
    <main>
      <h1>Últimas entradas</h1>
      <ul>
        {posts.map( ( post: WPPost ) => (
          <li key={post.id}>
            <a href={`/posts/${post.slug}`}>
              <h2 dangerouslySetInnerHTML={{ __html: post.title.rendered }} />
              <div dangerouslySetInnerHTML={{ __html: post.excerpt.rendered }} />
            </a>
          </li>
        ) )}
      </ul>
    </main>
  );
}
