<?php

namespace App\Services;

use GuzzleHttp\Client;

class ApiService
{

    private static function getResponse($url, $params) {
        $postdata = json_encode($params);


        $auth_key = env('SITE_API_KEY');
        $base_url = env('SITE_API_URL');
        $type = 'application/json';

        $client = new Client([
            'headers' => [
                'Content-Type' => $type,
                'Auth-Key' => $auth_key
            ]
        ]);
        $response = $client->post(
            $base_url.$url,
            [
                'body' => $postdata
            ],
        );

        $res = json_decode($response->getBody());

        return $res;
    }

    public static function userCheck($params) {
        $url = 'user/check';
        $data = self::getResponse($url, $params);

        return $data->status;
    }

    public static function userLogin($params) {
        $url = 'user/login';
        $data = self::getResponse($url, $params);

        return $data->status;
    }

    public static function userRegister($params) {
        $url = 'user/register';
        $data = self::getResponse($url, $params);

        return $data->status;
    }

    public static function userRestorePassword($params) {
        $url = 'user/restore_password';
        $data = self::getResponse($url, $params);

        return $data->status;
    }

    public static function userProfile($params) {
        $url = 'user/profile';
        $data = self::getResponse($url, $params);

        return $data;
    }

    public static function checkStore($params) {
        $url = 'check/store';
        $data = self::getResponse($url, $params);

        return $data;
    }

    public static function winnersWeeks($params) {
        $url = 'winners/weeks';
        $data = self::getResponse($url, $params);

        return $data;
    }

    public static function winnersList($params) {
        $url = 'winners/list';
        $data = self::getResponse($url, $params);

        return $data;
    }

    public static function questionSend($params) {
        $url = 'question/send';
        $data = self::getResponse($url, $params);

        return $data;
    }
}
