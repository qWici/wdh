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
        'timeout' => 14.14,
        'headers' => [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) 
                             Chrome/45.0.2454.93 Safari/537.36',
        ]
    ];

    public static function getRemoteContent($url, $params = null, $proxyLists = null)
    {
        self::validateURL($url);

        try {
            $response = (new GuzzleHttp\Client())->request(
                'GET', $url, (empty($params) ? self::$params : $params)
            );

            return $response->getStatusCode() == 200
                ? ['error' => 0, 'data' => (string)$response->getBody()]
                : ['error' => 2, 'message' => '404 Not found'];

        } catch (GuzzleHttp\Exception\RequestException $e) {

            return ['error' => 3, 'message' => "400 Bad Request | URL: {$url}"];

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