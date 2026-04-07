<?php

return [
    // Midtrans Configuration
    'is_production' => false, // Always false for SANDBOX
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', ''),
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),
    'server_key' => env('MIDTRANS_SERVER_KEY', ''),
    
    // Snap Configuration
    'snap_url' => 'https://app.sandbox.midtrans.com/snap/snap.js',
    
    // Webhook
    'webhook_url' => env('MIDTRANS_WEBHOOK_URL', ''),
];
