// Get the MemberPress user object
$mepr_user = new MeprUser( get_current_user_id() );

// Does the user have an active membership?
$active_memberships = $mepr_user->active_product_subscriptions( 'products' );

// Check if they have access to a specific membership (by product ID)
$product = new MeprProduct( $membership_id );
if ( $mepr_user->is_already_subscribed_to( $product ) ) {
    // access granted
}

// Data from the most recent transaction
$txn = $mepr_user->get_last_transaction();
if ( $txn instanceof MeprTransaction ) {
    $status  = $txn->status;    // 'complete', 'pending', 'refunded'
    $amount  = $txn->amount;
    $expires = $txn->expires_at;
}
