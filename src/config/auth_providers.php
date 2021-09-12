<?php
return[
    'users' => [
        'driver' => 'eloquent',
        'model' => Simbamahaba\Upepo\Models\User::class,
    ],

    'customers' => [
        'driver' => 'eloquent',
        'model' => Simbamahaba\Upepo\Models\Customer::class,
    ],

    'admins' => [
        'driver' => 'eloquent',
        'model' => Simbamahaba\Upepo\Models\Admin::class,
    ],
];
