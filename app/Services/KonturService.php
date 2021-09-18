<?php

namespace App\Services;

use App\Events\CreateDocflowEvent;
use App\Models\Docflow;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;


class KonturService

{
    private $client;

    //Констуктор
    function __construct() 
    {
        $this->client = KonturService::createClient();
    }
    //Статический метод на создание клиента 
    static function createClient() {
        return new Client([    
            'base_uri' =>  env('KONTUR_TEST_PLATFORM'),
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'ReestroAuth apiKey='.env('KONTUR_API_KEY').'&portal.orgid='.env('KONTUR_ORGID'). '',
            ],
        ]); 
    }


    //Добавление документооборота 
    public function insertDocflow(string $cadastralNumber)
        { 
            CreateDocflowEvent::dispatch($cadastralNumber);
        }


    //Функция обновления состояния 
    public static function refreshAllDocflowStates() { 
        $allDocflows = Docflow::where('docflow_state','<>','Processed')->get(); //Запрос где значение колонки docflow_stat не равно Processed
        $clientStatic = KonturService::createClient();
        foreach ($allDocflows as $docflow) {    //В цикле для каждого элемента docflow проверяем статус
            $response = $clientStatic->request('GET',"docflows/{$docflow->docflow_id}");
            $responseBody = json_decode($response->getBody()->getContents(),true);
            $docflow->docflow_state = $responseBody['docflowState']; // Состояние записывается в тело
            $docflow->save();
        }
    }
    //Функция обновления состояния документооборота по кнопке
    public function refreshDocflowState($docflowId) {
        $response = $this->client->request('GET',"docflows/{$docflowId}");

        $responseBody = json_decode($response->getBody()->getContents(),true);
        $docflowInstance = Docflow::where(['docflow_id' => $docflowId])->first(); // Обращение экземпляра к таблице docflowId из базы данных
        $docflowInstance->docflow_state = $responseBody['docflowState']; // Состояние записывается в тело
        $docflowInstance->save();

        return "Данные обновлены";
    }

    //Функция удаления документооборота
    public function deleteDocflowId($docflowId)
    {
        $docflowInstance = Docflow::where(['docflow_id' =>$docflowId])->first(); // Запрос к таблице docflowId 
        $docflowInstance->delete(); // Удаление 
        
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
 

    //Функция загрузки результатирующего файла по contentId
    public function downloadContent($contentId) 
    {
        $opts = array(          //Переменная с хедерами
            'http' => array(
                'method'  => "GET",
                'header'  => 'Authorization: ReestroAuth apiKey='.env('KONTUR_API_KEY') . '&portal.orgid=' . env('KONTUR_ORGID'),
            )
        ); 
        $context = stream_context_create($opts); // Создание контекста потока 
        $contentId = file_get_contents('https://api.testkontur.ru/realty/drive/v2/contents/' . $contentId, false, $context); // Получение файла по url 
        $filename = uniqid().'.zip'; // Присвоение уникального айди и расширения  
        Storage::disk('public')->put($filename, $contentId ); // Хранение на диске  пр имени файла и контент айди 
        return $filename;
    }
}
