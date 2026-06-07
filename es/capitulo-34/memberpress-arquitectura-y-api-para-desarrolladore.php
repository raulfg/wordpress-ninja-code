// Obtener el objeto usuario de MemberPress
$mepr_user = new MeprUser( get_current_user_id() );

// ¿Tiene el usuario una membresía activa?
$active_memberships = $mepr_user->active_product_subscriptions( 'products' );

// Comprobar si tiene acceso a una membresía concreta (por ID de producto)
$product = new MeprProduct( $membership_id );
if ( $mepr_user->is_already_subscribed_to( $product ) ) {
    // acceso permitido
}

// Datos de la transacción más reciente
$txn = $mepr_user->get_last_transaction();
if ( $txn instanceof MeprTransaction ) {
    $status  = $txn->status;    // 'complete', 'pending', 'refunded'
    $amount  = $txn->amount;
    $expires = $txn->expires_at;
}
