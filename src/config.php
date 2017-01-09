<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/11/3 下午4:23
 */

return [
    'api_server'    => env('ECS_API_SERVER', ''),
    'api_key'       => env('ECS_API_KEY', ''),
    'api_secret'    => env('ECS_API_SECRET', ''),
    'request_timeout'   => env('ECS_REQUEST_TIMEOUT', 3600)
];