<?php

use App\Models\User;
use Ramsey\Uuid\Uuid;

if (!function_exists('unique_api_token')) {
    /**
     * Generate unique API token
     * @return mixed|string
     * @throws Exception
     */
    function unique_api_token()
    {
        $token = Uuid::uuid1()->toString();
        if (!is_null(User::whereApiToken($token)->first())) {
            return call_user_func(unique_api_token());
        }

        return $token;
    }
}
