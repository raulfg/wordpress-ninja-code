async function toggleFavorite( postId ) {
    const formData = new FormData();
    formData.append( 'action', 'ninja_save_favorite' );
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
        throw new Error( data.data?.message ?? 'Unknown error' );
    }

    return data.data.favorite;
}
