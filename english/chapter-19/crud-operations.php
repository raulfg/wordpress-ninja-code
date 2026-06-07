// INSERT
$wpdb->insert(
    $wpdb->prefix . 'orders',
    [
        'user_id' => $user_id,
        'total'   => $total,
        'status'  => 'pending',
        'date'    => current_time('mysql'),
    ],
    ['%d', '%f', '%s', '%s']
);

$new_id = $wpdb->insert_id; // ID of the inserted record

// UPDATE
$wpdb->update(
    $wpdb->prefix . 'orders',
    ['status' => 'completed'],  // data to update
    ['ID' => $order_id],        // WHERE condition
    ['%s'],                     // format of the data
    ['%d']                      // format of the condition
);

// DELETE
$wpdb->delete(
    $wpdb->prefix . 'orders',
    ['ID' => $order_id],
    ['%d']
);
