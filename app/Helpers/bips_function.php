<?php
/**
 * Created by PhpStorm.
 * User: Angga-PC
 * Date: 15/06/2020
 * Time: 13.28
 */

function behost(){
    $be_host = 'http://bahana.ihsansolusi.co.id:15000';
    return $be_host;
}

function backendCallGET($json,$beHost){
    $client = new \GuzzleHttp\Client();
    try {
        $response = $client->request('GET', behost() . $beHost, [
            'json' => $json,
            'headers' => [
                'Content-type' => 'application/json',
            ],
            'config' => [
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false
                ]
            ]
        ]);

        $body = $response->getBody();
        $content = $body->getContents();
        $arr = json_decode($content, TRUE);

        return $arr;
    } catch (\GuzzleHttp\Exception\ConnectException $e){
        $error_code = "01";
        return $error_code;
    }
}