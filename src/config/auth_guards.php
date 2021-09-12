<?php
return[
    'customer' => [
        'driver' => 'session',
        'provider' => 'customers',
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
];
