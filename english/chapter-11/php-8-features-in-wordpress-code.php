// Traditional switch
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

// Match — expression, not statement; returns a value directly
$query_orderby = match( $orderby ) {
    'title'      => 'title',
    'menu_order' => 'menu_order',
    default      => 'date',
};
