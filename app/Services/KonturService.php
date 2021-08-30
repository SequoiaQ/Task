<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Docflow;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class KonturService extends Controller

{
    private $client;

    //Констуктор
    function __construct() 
    {
        $this->client = new Client([
            'base_uri' =>  env('KONTUR_TEST_PLATFORM'),
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'ReestroAuth apiKey='.env('KONTUR_API_KEY').'&portal.orgid='.env('KONTUR_ORGID').'',
            ],
        ]);
    }

    //Функция создания документооборота
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

    //Функция обновления состояния документооборота
    public function refreshDocflowState($docflowId) {
        $response = $this->client->request('GET',"docflows/{$docflowId}");

        $responseBody = json_decode($response->getBody()->getContents(),true);
        $docflowInstance = Docflow::where(['docflow_id' => $docflowId])->first();
        $docflowInstance->docflow_state = $responseBody['docflowState'];
        $docflowInstance->save();

        return "Данные обновлены";
    }

    //Функция удаления документооборота
    public function deleteDocflowId($docflowId)
    {
        $docflowInstance = Docflow::where(['docflow_id' =>$docflowId])->first();
        $docflowInstance->delete();
        
        return "Данные удалены";
    }

    //Функция отправки, получения состояния
    public function sendDocflow($docflowId)
    {
        $response = $this->client->request('POST', "docflows/{$docflowId}/send", [
            'debug' => true,
        ]);
        return $response->getBody();
    }

    //Функция получения конкретного документооборота
    public function getContentId($docflowId = 'a4308580-cec3-11eb-948a-69a09446260d')
    {
        // FixMe: потереть хедеры ткк client сздается в конструкторе
        $response = $this->client->request('GET', env('KONTUR_TEST_PLATFORM') . 'docflows/' . $docflowId, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'ReestroAuth apiKey=' . env('KONTUR_API_KEY') . '&portal.orgid=' . env('KONTUR_ORGID').'',
            ],
        ]);
        $response = json_decode($response->getBody()->getContents(), true);
        $this->downloadContent($response["rosreestrResponses"][0]["outdoc"]["content"]["contentId"]);
    }

    //Функция загрузки результатирующего файла по contentId
    public function downloadContent($contentId)
    {
        $opts = array(
            'http' => array(
                'method'  => "GET",
                'header'  => 'Authorization: ReestroAuth apiKey='.env('KONTUR_API_KEY') . '&portal.orgid=' . env('KONTUR_ORGID'),
            )
        ); 
        $context = stream_context_create($opts);
        $contentId = file_get_contents('https://api.testkontur.ru/realty/drive/v2/contents/' . $contentId, false, $context);
        $filename = uniqid().'.zip';
        Storage::disk('local')->put($filename, $contentId );
        return $filename;
    }

}
