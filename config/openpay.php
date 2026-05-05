<?php

return [
    'mode' => env('OPENPAY_MODE', 'sandbox'),
    'merchant_id' => env('OPENPAY_MERCHANT_ID'),
    'private_key' => env('OPENPAY_PRIVATE_KEY'),
    'public_key' => env('OPENPAY_PUBLIC_KEY'),
    'location' => env('OPENPAY_LOCATION', 'MX'),
    
    'urls' => [
        'sandbox' => 'https://sandbox-api.openpay.mx/v1/',
        'production' => 'https://api.openpay.mx/v1/',
    ],
];
