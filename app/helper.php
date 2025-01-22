<?php

use App\Services\ResponseService;

if (!function_exists('responder')) {
    function responder(): ResponseService
    {
        return app(ResponseService::class);
    }
}