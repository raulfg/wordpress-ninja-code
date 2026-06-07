// src/pages/portfolio/[slug].astro
---
import Layout from '../../layouts/Layout.astro';

const { slug } = Astro.params;

const response = await fetch(
    `${import.meta.env.WORDPRESS_API_URL}/wp/v2/portfolio?slug=${slug}&_embed`
);
const [ post ] = await response.json();

if ( ! post ) {
    return Astro.redirect( '/404' );
}
---

<Layout title={ post.title.rendered }>
    <article>
        <h1 set:html={ post.title.rendered } />
        <div class="content" set:html={ post.content.rendered } />
    </article>
</Layout>
