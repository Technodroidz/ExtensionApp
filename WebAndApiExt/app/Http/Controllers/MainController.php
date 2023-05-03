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
            'type' => 'service_account',
            "project_id" => 'vikash27hbk-8ef7a',
            "private_key_id"=> 'c4bc86d9b39ef4697cbd742cb6573cfd74d9c24b',
            "private_key"=> "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCMKqRtrwnk5Few\nm8Ydz+0rDUb853mxZM7zkWBIaMLCGXD+UXAqW89vqDbQjwmGee0Gz2ciiD6g/mm6\n3fMAlVOCHtPf+rzsVUnqBHE0vPxdrSByjVDmYHXNpvCv9hrY6Z/KmKQiRJinIu6n\nj8L05Llf+isvgaIQMrto8yoVC2QcsSnefUC1LlbWmDbE+WcxD3li1E/1/LA/CSSj\ni1ZcRbicwftOcd7iHAJM+oW8ox2BJP1MZZOBs4LqkR6sxtkqudmRQL8uchTjYWUq\n0lsU073s9c2aXIW25BMUaj4+Ahzy1HIy4q2YUTqXfMuh20nJiiiV3p1OnrAcfYF4\nqpp1OyVnAgMBAAECggEADBTs4WtyDeHE0TtMI2u1xL07PjdxnOHUmNgSFYu6JeLt\ng25fnbcWNUipmOaLaqT90lV0TVyzEUt8r5fMB2PXs+KWXrsNJ83eNia131be5fAz\nWMxnicQMw3I9Ut2CyOmyVVM86ptBET8IlTbmFhfVBrnYmRqybnUBBHXZTcESmwpl\np+FP40dLCYSyW8qOA0cq2+EKVTpXyWFDM3sU8NQdr4mYt9p3sS2dDr/MIW0KPmXa\n68jnJwYN5eVNEVIJSr5pKv86ee+LYJohvpvOW5PUODZvvYzW+sRfSe4nCmh7thmR\n8Pf4BwzrtqxMD25jmxfHfWmkP9XbT1745IiSbXibgQKBgQDCRrg+kJIfslUZtBHM\nKSDmApzFBCbgBM6l3zcrmrozA7J/EO0avG7M72AFwUNEdWsdURoRnYVbqzEiYfpi\njOEdQlWFl+uJ1WzrvM5qYYG2U378/gC6dnt4TeIH0AjP1kF6iiiwEiik1v436Vla\nJss/G6UCPFvSR1mgpDlJcIsPQQKBgQC4svYwS4esEeun5cQhc3Z6OO5YUAUrdvO6\nU3mI+cgiO1Sg7WNu1HQNVWhWr/U66Y1QKM1M33U3ENMYImp1ZylcICIJuZm+ZJRW\n9Gckb5t0IjQQX5tCl0/nZOXLi39M52dTFf3gYkTrVIwMagrLROAO5rWzedpP13vf\nlVbaSKmypwKBgHo2WLLq6TFNUuF/eG6xNMPcwtfhO79S5thLqf4hMJ7k5YWvlShr\nf1wl/YbBQ9qt7rsbiMWqDPlUoO0bK5KRQw/P6dLHdeFYRFOri0I6oomaztjBxJ2H\n6TYN8HGvuctc4gX/IYdZdP31TSjI/2+J1fOWJWBZrf2C6uv2Qx9iz+fBAoGAcyDC\nipoaCKzm+rIjDkLdoBPqpcvDXTN5ezRbNoGUOZpIB0PRzhzJ9iG9twNZVg6M0mGM\njxVfCCMJoiqZt3LFejJhZTR23BHv0T/pJvIWsU48q9QcgGa3HOJsxvK+OB6p7kVw\nCbTXhuUdowNalRfqnf87VZNn/IqyIU0CZXATr1MCgYAeuIsNUETZ5UKNxxLHig7o\nKGImVGgT2UDsbr92QAl8mvuijfeMaJbZ3BCZXg4ztSkkGTc1AqT/czXfpAW5xyXA\nS+euyrJ5sfpS6/5pd3Wd94Z/yYE+72DRwn8UYfmQPLX2R+ny7VA9KszIFpMMS+Dw\n4Ctens4OAa6/oR2Fn+7AnA==\n-----END PRIVATE KEY-----\n",
            "client_email"=> "firebase-adminsdk-jrst0@vikash27hbk-8ef7a.iam.gserviceaccount.com",
            "client_id"=> '104797735619460884915',
            "auth_uri"=> 'https://accounts.google.com/o/oauth2/auth',
            "token_uri"=> 'https://oauth2.googleapis.com/token',
            "auth_provider_x509_cert_url"=> 'https://www.googleapis.com/oauth2/v1/certs',
            "client_x509_cert_url"=> 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-jrst0%40vikash27hbk-8ef7a.iam.gserviceaccount.com'
            ]);
            $firebase = (new Factory)
                ->withServiceAccount($serviceAccount)
                ->withDatabaseUri('https://vikash27hbk-8ef7a-default-rtdb.firebaseio.com')
                ->createDatabase();  
        
        $reference = $firebase->getReference('root/history'.$refer);
        $data = $reference->getValue();
        if($data){
        foreach ($data as $key => $value) {
            $key = 'EncryptionApp';
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
