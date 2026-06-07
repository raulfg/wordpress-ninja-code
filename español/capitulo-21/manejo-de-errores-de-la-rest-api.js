async function fetchConError( url, opciones = {} ) {
    const response = await fetch( url, opciones );

    if ( ! response.ok ) {
        let mensaje = `HTTP ${response.status}`;

        try {
            const errorData = await response.json();
            mensaje = errorData.message ?? mensaje;
        } catch {
            // El cuerpo no era JSON, usar el mensaje HTTP genérico
        }

        throw new Error( mensaje );
    }

    return response.json();
}
