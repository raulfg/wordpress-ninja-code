async function toggleFavorito( postId ) {
    const formData = new FormData();
    formData.append( 'action', 'ninja_guardar_favorito' );
    formData.append( 'nonce', ninjaAjax.nonce );
    formData.append( 'post_id', postId );

    const response = await fetch( ninjaAjax.url, {
        method: 'POST',
        body: formData,
    } );

    if ( ! response.ok ) {
        throw new Error( `HTTP ${response.status}` );
    }

    const data = await response.json();

    if ( ! data.success ) {
        throw new Error( data.data?.mensaje ?? 'Error desconocido' );
    }

    return data.data.favorito;
}
