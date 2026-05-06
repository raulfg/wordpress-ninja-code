// src/portfolio/render.js

export function createPortfolioCard( post ) {
    const article = document.createElement( 'article' );
    article.className = 'portfolio-card';
    article.dataset.id = post.id;

    const categoriesHtml = post.categories
        .map( cat => `<a href="${ cat.url }" class="portfolio-cat">${ cat.name }</a>` )
        .join( '' );

    const thumbnailHtml = post.thumbnail?.large
        ? `<div class="portfolio-card__thumb">
               <a href="${ post.url }" aria-hidden="true" tabindex="-1">
                   <img src="${ post.thumbnail.large }"
                        alt="${ post.title }"
                        loading="lazy"
                        decoding="async">
               </a>
           </div>`
        : '';

    article.innerHTML = `
        ${ thumbnailHtml }
        <div class="portfolio-card__body">
            <h3 class="portfolio-card__title">
                <a href="${ post.url }">${ post.title }</a>
            </h3>
            ${ post.meta.client
                ? `<p class="portfolio-card__client">${ post.meta.client }</p>`
                : '' }
            ${ categoriesHtml
                ? `<div class="portfolio-card__categories">${ categoriesHtml }</div>`
                : '' }
        </div>
    `;

    return article;
}

export function showLoading( container ) {
    const loader = document.createElement( 'div' );
    loader.className = 'portfolio-loading';
    loader.setAttribute( 'aria-live', 'polite' );
    loader.textContent = window.ninjaPortfolio.i18n.loading;
    container.appendChild( loader );
    return loader;
}
