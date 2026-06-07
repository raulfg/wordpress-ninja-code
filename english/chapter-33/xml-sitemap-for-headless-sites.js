// next-sitemap.config.js
module.exports = {
    siteUrl: 'https://ninjatheme.com',
    generateRobotsTxt: true,

    // Fetch additional routes from WordPress (portfolio, pages, etc.)
    additionalPaths: async ( config ) => {
        const response  = await fetch(
            `${process.env.WORDPRESS_API_URL}/wp/v2/portfolio?per_page=100&_fields=slug,modified`
        );
        const posts = await response.json();

        return posts.map( ( post ) => ( {
            loc:        `${config.siteUrl}/portfolio/${post.slug}/`,
            lastmod:    post.modified,
            changefreq: 'monthly',
            priority:   0.7,
        } ) );
    },

    robotsTxtOptions: {
        policies: [
            { userAgent: '*', allow: '/' },
            // Block direct access to the WordPress backend
            { userAgent: '*', disallow: '/wp-admin/' },
        ],
    },
};
