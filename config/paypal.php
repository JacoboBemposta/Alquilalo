<?php

return [
    'client_id' => env('PAYPAL_CLIENT_ID_' . strtoupper(env('PAYPAL_MODE')), 'default_client_id'),
    'client_secret' => env('PAYPAL_CLIENT_SECRET_' . strtoupper(env('PAYPAL_MODE')), 'default_client_secret'),
    'mode' => env('PAYPAL_MODE', 'sandbox'), // o 'live'
];