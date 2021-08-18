<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class KonturService

{

    
    private $client;

    function __construct() {
        $this->client = new Client();
    }

    public function createDocflow()
    {
        $response = $this->client->request('POST', env('KONTUR_TEST_PLATFORM').'docflows', [
            'json' => [
            "objectExtract" => array(
                    "extractType" => "Base",
                    "objects" => [array(
                        "cadastralNumber" => "54:12:345814:45",
        )]
        )
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'ReestroAuth apiKey='.env('KONTUR_API_KEY').'&portal.orgid='.env('KONTUR_ORGID').'',
                ],
                'debug' => true,
        ]);
        echo($response->getBody());
    }

    public function sendDocflow($docflowId)
    {
        $response = $this->client->request('POST', env('KONTUR_TEST_PLATFORM').'docflows/'.$docflowId.'/send', [

            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'ReestroAuth apiKey='.env('KONTUR_API_KEY').'&portal.orgid='.env('KONTUR_ORGID').'',
            ],
            'debug' => true,
        ]);
        var_dump($response);
    }

}
