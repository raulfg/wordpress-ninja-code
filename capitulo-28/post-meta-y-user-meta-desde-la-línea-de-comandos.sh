# Leer el meta de un post
wp post meta get 42 _proyecto_cliente

# Actualizar el meta en un post concreto
wp post meta update 42 _proyecto_cliente "Nueva empresa S.A."

# Actualizar un meta en todos los posts de un CPT (con for loop bash)
for post_id in $(wp post list --post_type=portfolio --format=ids); do
    wp post meta update $post_id _proyecto_activo "1"
done

# Buscar posts que tengan un meta específico
wp post list --post_type=portfolio --meta_key=_proyecto_destacado --meta_value=1 --format=table

# Borrar un meta de todos los posts
for post_id in $(wp post list --post_type=portfolio --format=ids); do
    wp post meta delete $post_id _campo_obsoleto
done
