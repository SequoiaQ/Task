<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class MainController extends Controller
{


    public function list(){
        $attachment = Attachment::all();
        return response()->json([
            'attachment' => $attachment,
        ]);
    }

    public function tableOnPage(){
      $attachment = Attachment::all()->toArray();
      return view('attachments.list', compact('attachment'));

    } 

    public function delete(Attachment $attachment) {
        $attachment->delete();
        return 'Удалено успешно';
    }

    public function update(Attachment $attachment, Request $request) {
        $attachment->filename = $request['name'];
        $attachment->save();

        return 'Файл успешно обновлён';
    }

    public function fileUpload(Request $req){
        $formData = $req->validate([
            'name' => 'required',
        ]);
        $attachment = new Attachment();

        $fileName = time().'_'.$req->file->getClientOriginalName();
        $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');

        $attachment->filename = $formData['name'];
        $attachment->url = Storage::url($filePath);
        $attachment->local_path = $filePath;
        $attachment->save();

        return 'файл успешно отправлен';
   }

   function guzzleMethod(){
       $client = new Client();

       $response = $client->request('POST', env('KONTUR_TEST_PLATFORM').'docflows', [
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
           var_dump($response);
           echo env('KONTUR_API_KEY');
   }
}
