<?php

return [
    'paths' => ['api/*'], // Áp dụng CORS cho API routes
    'allowed_methods' => ['POST', 'GET', 'DELETE', 'PUT', 'PATCH', 'OPTIONS'],
    'allowed_origins' => ['http://localhost:3000', 'http://localhost:5173'], // Add your frontend URLs
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Cho phép tất cả headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Change this to true if you're using cookies/session
];

?>