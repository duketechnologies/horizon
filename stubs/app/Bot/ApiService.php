<?php

namespace App\Bot;

use Illuminate\Support\Facades\Http;

class ApiService
{
    private static function getResponse($url, $data) {
        $params = user_storage()->toArray();
        $params += $data;

        $auth_key = env('SITE_API_KEY');
        $base_url = env('SITE_URL') . '/api/';

        $client = Http::withHeaders(['Auth-Key' => $auth_key])->post($base_url.$url, $params);

        $response = $client->json();
        dump($response);
        return $response;
    }

    public static function userLogin($data = []) {
        $url = 'user/login';
        $response = self::getResponse($url, $data);

        return isset($response['status']) ? $response['status'] : false;
    }

    public static function userRegister($data = []) {
        $url = 'user/register';
        $response = self::getResponse($url, $data);

        return isset($response['status']) ? $response['status'] : false;
    }

    public static function userRestorePassword($data = []) {
        $url = 'user/restore_password';
        $response = self::getResponse($url, $data);

        return isset($response['status']) ? $response['status'] : false;
    }

    public static function userProfile($data = []) {
        $url = 'user/profile';
        $response = self::getResponse($url, $data);

        return $response;
    }

    public static function checkStore($data = []) {
        $url = 'check/store';
        $response = self::getResponse($url, $data);

        return $response;
    }

//    public static function winnersWeeks($data = []) {
//        $url = 'winners/weeks';
//        $response = self::getResponse($url, $data);
//
//        return $response;
//    }
//
//    public static function winnersList($data = []) {
//        $url = 'winners/list';
//        $response = self::getResponse($url, $data);
//
//        return $response;
//    }

    public static function questionSend($data = []) {
        $url = 'question/send';
        $response = self::getResponse($url, $data);

        return $response;
    }
}
