<?php

namespace App\Helpers;

use App\Helpers\RemoteRequest;

class ParseResource
{
    /**
     * Get resource data from Gitlab storage
     * https://gitlab.com/qWici/webdev-resources
     *
     * @param $resourceType
     * @return mixed
     */
    public static function getData($resourceType)
    {
        $response = RemoteRequest::getRemoteContent(config('resources.' .$resourceType));
        if(! array_key_exists("data", $response)) {
            var_dump($response);
            return self::getData($resourceType);
        }

        return json_decode($response["data"]);
    }
}