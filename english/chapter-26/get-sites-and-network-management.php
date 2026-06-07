// All active sites in the network
$sites = get_sites( [
    'number'   => 0,     // 0 = no limit
    'archived' => 0,
    'spam'     => 0,
    'deleted'  => 0,
] );

// Sites registered in the last 30 days
$recent = get_sites( [
    'number'       => 10,
    'registered__gte' => date( 'Y-m-d', strtotime( '-30 days' ) ),
] );

// Count network sites
$total = get_sites( [ 'count' => true ] );
