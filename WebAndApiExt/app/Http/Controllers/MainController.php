<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class MainController extends Controller
{
    public function index(Request $request){
         $machineId = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $refer = base64_encode($machineId); 
        
         $serviceAccount = ServiceAccount::fromValue([
        'type' => env('TYPE'),
        "project_id" => env('PROJECT_ID'),
        "private_key_id"=> env('PRIVATE_KEY_ID'),
        "private_key"=> env('PRIVATE_KEY'),
        "client_email"=> env('CLIENT_EMAIL'),
        "client_id"=> env('CLIENT_ID'),
        "auth_uri"=> env('AUTH_URI'),
        "token_uri"=> env('TOKEN_URI'),
        "auth_provider_x509_cert_url"=> env('AUTH_PROVIDER_x509_CERT_URL'),
        "client_x509_cert_url"=> env('CLIENT_x509_CERT_URL')
        ]);
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri(env('DATABASE_URI'))
            ->createDatabase();  
        
        $reference = $firebase->getReference('root/history'.$refer);
        $data = $reference->getValue();
        if($data){
        foreach ($data as $key => $value) {
             $key = "EncryptionApp";
             $iv = random_bytes(16);
            $url = openssl_decrypt($value["url"], "aes-256-cbc", $key, 0, $iv);
            $historydata[] = [
             'key' =>  $key,
             'date' => $value["date"],
             'machine_id' => $value["machineid"],
             'time' => $value["time"],
             'url' => base64_decode($value["url"])
         ];
    }
        }else{
            $historydata[] = [];
        }
        
        return view('index',compact('historydata'));
    }
}
