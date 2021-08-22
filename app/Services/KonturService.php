<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Docflow;
use GuzzleHttp\Client;

class KonturService

{
    private $client;
    function __construct() {
        $this->client = new Client([
            'base_uri' =>  env('KONTUR_TEST_PLATFORM'),
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'ReestroAuth apiKey='.env('KONTUR_API_KEY').'&portal.orgid='.env('KONTUR_ORGID').'',
            ],
        ]);
    }

    public function createDocflow()
    {
        $response = $this->client->request('POST','docflows', [
            'json' => [
            "objectExtract" => array(
                    "extractType" => "Base",
                    "objects" => [array(
                        "cadastralNumber" => "54:12:345814:45",
                )]
            )
            ],
        ]);
        $responseBody = json_decode($response->getBody()->getContents(),true);
        $docflowInstance = new Docflow();
        $docflowInstance->docflow_state = $responseBody['docflowState'];
        $docflowInstance->docflow_id = $responseBody['docflowId'];
        $docflowInstance->save();
        return 'Docflow saved';
    }

    public function refreshDocflowState($docflowId) {
        $response = $this->client->request('GET',"docflows/{$docflowId}");

        $responseBody = json_decode($response->getBody()->getContents(),true);
        $docflowInstance = Docflow::where(['docflow_id' => $docflowId])->first();
        $docflowInstance->docflow_state = $responseBody['docflowState'];
        $docflowInstance->save();

        return "Данные обновлены";
    }
    public function sendDocflow($docflowId)
    {
        $response = $this->client->request('POST', "docflows/{$docflowId}/send", [
            'debug' => true,
        ]);
        return $response->getBody();
    }

    public function getContentId($contentId)
    {
        $client = $this->client->request('GET','contents/'.$contentId, [
            'debug' => true,
            'sink' => '/path/to/file'
        ]);
        echo($client->getBody());

    }

}
