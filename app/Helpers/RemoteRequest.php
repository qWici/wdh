<?php

namespace App\Helpers;
use GuzzleHttp;

class RemoteRequest
{
    public static $params = [
        "allow_redirects" => true,
        "exceptions" => true,
        "decode_content" => true,
        "verify" => false,
        'timeout' => 14,
        'delay' => 2500,
        'headers' => [
            'Cache-Control' => 'no-cache',
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.172 Safari/537.36 Vivaldi/2.5.1525.48',
        ]
    ];

    public static function getRemoteContent($url, $params = [], $proxyLists = null)
    {
        self::validateURL($url);

        $requestParams = array_merge_recursive(self::$params, $params);

        try {
            $response = (new GuzzleHttp\Client())->request(
                'GET', $url, $requestParams
            );

            return $response->getStatusCode() == 200
                ? ['error' => 0, 'data' => (string)$response->getBody()]
                : ['error' => 2, 'message' => '404 Not found'];

        } catch (GuzzleHttp\Exception\RequestException $e) {

            return [
                'error' => 3,
                'message' => "400 Bad Request | URL: {$url}",
                "exception" => $e
            ];
        }
    }

    public static function validateURL($url)
    {
        return empty($url)
            ? ['error' => 1, 'message' => 'Bad URL']
            : false;
    }

    public static function getExtension($filename)
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);

        if ($finfo->buffer($filename) == 'image/jpg') {
            $extension = 'jpg';
        } elseif ($finfo->buffer($filename) == 'image/jpeg') {
            $extension = 'jpeg';
        } elseif ($finfo->buffer($filename) == 'image/png') {
            $extension = 'png';
        } elseif ($finfo->buffer($filename) == 'image/gif') {
            $extension = 'gif';
        }
        if (isset($extension)) {
            return $extension;
        } else {
            return 'png';
        }
    }
}