add_action(
    'quick_edit_custom_box',
    function( string $column, string $post_type ): void {
        if ( 'portfolio' !== $post_type || 'client' !== $column ) {
            return;
        }
        ?>
        <fieldset class="inline-edit-col-right">
            <div class="inline-edit-col">
                <label>
                    <span class="title">
                        <?php esc_html_e( 'Cliente', 'ninja-portfolio' ); ?>
                    </span>
                    <span class="input-text-wrap">
                        <input type="text"
                               name="_npe_client_name"
                               class="ptitle"
                               value="">
                    </span>
                </label>
            </div>
            <div class="inline-edit-col">
                <label class="inline-edit-featured">
                    <input type="checkbox"
                           name="_npe_is_featured"
                           value="1">
                    <span class="checkbox-title">
                        <?php esc_html_e( 'Proyecto destacado', 'ninja-portfolio' ); ?>
                    </span>
                </label>
            </div>
        </fieldset>
        <?php
    },
    10,
    2
);
