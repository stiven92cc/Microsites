<?php

return [
    'services' => [
        'current' => env('CURRENT_GATEWAY', 'placetopay'),
        'placetopay' => [
            'class' => \App\PaymentGateway\PlacetopayGateway::class,
            'settings' => [
                'login' => env('PLACETOPAY_LOGIN', 'test'),
                'tranKey' => env('PLACETOPAY_TRANKEY', 'test'),
                'baseUrl' => env('PLACETOPAY_BASE_URL','https://test.com/redirection'),
            ]
        ],

    ]
];
