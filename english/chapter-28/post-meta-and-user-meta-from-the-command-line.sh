# Read a post's meta field
wp post meta get 42 _proyecto_cliente

# Update meta on a specific post
wp post meta update 42 _proyecto_cliente "New Company Inc."

# Update meta on all posts of a CPT (using a bash for loop)
for post_id in $(wp post list --post_type=portfolio --format=ids); do
    wp post meta update $post_id _proyecto_activo "1"
done

# Find posts that have a specific meta key
wp post list --post_type=portfolio --meta_key=_proyecto_destacado --meta_value=1 --format=table

# Delete a meta field from all posts
for post_id in $(wp post list --post_type=portfolio --format=ids); do
    wp post meta delete $post_id _campo_obsoleto
done
