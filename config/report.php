<?php

return [
    'output' => [
        'rekomendasi_formasi' => env('REPORT_LOCATION')
    ],
    'input' => [
        'rekomendasi_formasi' => env('REPORT_TEMPLATE') . 'sijupri_rekomendasi_formasi.jasper'
    ],


    'connection' => [
        'driver' => env('DB_DRIVER'), //'postgres', 
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'host' => env('DB_HOST'),
        'database' => env('DB_DATABASE'),
        'port' => env('DB_PORT'),
    ]
];
