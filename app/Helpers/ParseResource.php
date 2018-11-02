<?php

namespace App\Helpers;

use App\Helpers\RemoteRequest;

class ParseResource
{
    public static function getData($resourceType)
    {
        $response = RemoteRequest::getRemoteContent(config('resources.' .$resourceType));
        return json_decode($response['data']);
    }
}