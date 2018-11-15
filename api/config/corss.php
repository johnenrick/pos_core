<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */

    'supportsCredentials' => false,
    'allowedOrigins' => [],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['Origin', 'X-Requested-With', 'Content-Type', 'Accept', 'Authorization', 'authorization', 'Token', 'token'],
    'allowedMethods' => ['POST', 'GET', 'OPTIONS', 'options', 'DELETE', 'PUT'],
    'exposedHeaders' => ['Token', 'token', 'Authorization', 'authorization'],
    'maxAge' => 0,

];
