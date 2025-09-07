<?php

namespace App\Services;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;

class GoogleAccessTokenServices
{
    public Static function getAccessToken()
    {
        try{

        
      $servicesAccount = json_decode(file_get_contents(config_path('product-selling-app-a75ce-cc816df1044d.json')), true);
       $privateKey = $servicesAccount['private_key'];
        $clientEmail = $servicesAccount['client_email'];
        $now = time();

        $jwtPayload = [
            'iss' => $clientEmail,
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ];

       $JWT = JWT::encode($jwtPayload, $privateKey, 'RS256');

      $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $JWT,
        ]);

    \Log::info("Response coming from google fcm");
    \Log::info($response);
    if($response->successful()){
        $accessToken = $response->json()['access_token'];
        return $accessToken;
    }
    throw new \Exception('Failed to get access token from Google.');
}
    catch(\Exception $e){
        \Log::error("Error getting Google access token: " . $e->getMessage());
        return null;
    }
    }
}

?>