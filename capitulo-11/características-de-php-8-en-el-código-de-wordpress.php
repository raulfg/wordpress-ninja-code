// Switch tradicional
switch ( $orderby ) {
    case 'title':
        $query_orderby = 'title';
        break;
    case 'menu_order':
        $query_orderby = 'menu_order';
        break;
    default:
        $query_orderby = 'date';
}

// Match — expresión, no sentencia; devuelve un valor directamente
$query_orderby = match( $orderby ) {
    'title'      => 'title',
    'menu_order' => 'menu_order',
    default      => 'date',
};
