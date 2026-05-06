// Worker que añade el header de variante de A/B test
export default {
    async fetch(request) {
        const url = new URL(request.url);

        // Solo en la portada
        if (url.pathname !== '/') {
            return fetch(request);
        }

        const variant = Math.random() < 0.5 ? 'a' : 'b';
        const response = await fetch(request);
        const newResponse = new Response(response.body, response);
        newResponse.headers.set('X-AB-Variant', variant);
        return newResponse;
    }
};
