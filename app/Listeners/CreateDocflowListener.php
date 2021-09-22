<?php

namespace App\Listeners;

use App\Events\CreateDocflowEvent;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
 

class CreateDocflowListener implements ShouldQueue
{
    public function handle(CreateDocflowEvent $event)
    {

        $cadastralNumber = $event->cadastralNumber;
        $client = new Client([    
            'base_uri' =>  env('KONTUR_TEST_PLATFORM'),
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'ReestroAuth apiKey='.env('KONTUR_API_KEY').'&portal.orgid='.env('KONTUR_ORGID'). '',
            ],
        ]);
        $response = $client->request('POST',"docflows",[
            'json' => [
            "objectExtract" => array(
                    "extractType" => "Base",
                    "objects" => [array(
                        "cadastralNumber" => $cadastralNumber,
                )], 
            )
            ],
        ]);

        $responseContents = $response->getBody()->getContents(); 
        $responseBody = json_decode($responseContents,true); //Декодирование формата json
        //sleep(20);
                DB::table('docflows')->where('id', $event->id)->update([ 
                'docflow_state' => $responseBody['docflowState'],
                'docflow_id' => $responseBody['docflowId'],
            ]);
    }
}