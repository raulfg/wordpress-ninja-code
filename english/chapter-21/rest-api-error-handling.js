async function fetchWithError( url, options = {} ) {
    const response = await fetch( url, options );

    if ( ! response.ok ) {
        let message = `HTTP ${response.status}`;

        try {
            const errorData = await response.json();
            message = errorData.message ?? message;
        } catch {
            // Body was not JSON, use the generic HTTP message
        }

        throw new Error( message );
    }

    return response.json();
}
