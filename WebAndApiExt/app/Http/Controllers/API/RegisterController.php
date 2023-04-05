<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;



class RegisterController extends BaseController
{
    public function generateRandomString($length) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
  
    public function saveURL(Request $request)
    {
        $id = $this->generateRandomString(2);
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
        
        $reference = $firebase->getReference('root');
        $value = $reference->getValue();
        $machineId = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $refer = base64_encode($machineId);
       $message = $request->url;
       $key = env('ENCRYPTION_KEY');
       $iv = random_bytes(16);
        $encrypted_message = base64_encode($message);

        if(!empty($request->url) and !empty($request->machineid)){
        $newData = $firebase->getReference('root/history'.$refer)
        ->push([
            'url' => $encrypted_message,
            'machineid' => $machineId,
            'date' => date('Y-m-d'),
            'time' => date('H:i:s')
        ]);
    }
        return response()->json($reference->getValue());
                
    }

    

}