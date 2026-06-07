// INSERT
$wpdb->insert(
    $wpdb->prefix . 'pedidos',
    [
        'usuario_id' => $usuario_id,
        'total'      => $total,
        'estado'     => 'pendiente',
        'fecha'      => current_time('mysql'),
    ],
    ['%d', '%f', '%s', '%s']
);

$nuevo_id = $wpdb->insert_id; // ID del registro insertado

// UPDATE
$wpdb->update(
    $wpdb->prefix . 'pedidos',
    ['estado' => 'completado'],   // datos a actualizar
    ['ID' => $pedido_id],         // condición WHERE
    ['%s'],                       // formato de los datos
    ['%d']                        // formato de la condición
);

// DELETE
$wpdb->delete(
    $wpdb->prefix . 'pedidos',
    ['ID' => $pedido_id],
    ['%d']
);
