<?php

return [
    'name' => getenv('APP_NAME') ?: 'VC VPN 2027',
    'env' => getenv('APP_ENV') ?: 'production',
    'debug' => filter_var(getenv('APP_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN),
    'url' => getenv('APP_URL') ?: 'http://localhost',
    'timezone' => 'Asia/Ho_Chi_Minh',
    'locale' => 'vi',
];