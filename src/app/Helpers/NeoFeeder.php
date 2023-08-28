<?php

namespace Aseplab\Neofeeder\App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class NeoFeeder {
    private $urlFeeder;
    private $username;
    private $password;
    private $act;

    function __construct($act)
    {
        if(env('MODE_NEOFEEDER')) {
            $urlFeeder = env('URL_NEOFEEDER').'ws/live2.php';
        } else {
            $urlFeeder = env('URL_NEOFEEDER').'ws/sandbox2.php';
        }

        $this->urlFeeder = $urlFeeder;
        $this->username = env('USERNAME_NEOFEEDER');
        $this->password = env('PASSWORD_NEOFEEDER');
        $this->act = $act;
    }

    private function getToken()
    {
        $response = Http::post($this->urlFeeder, [
            'act' => 'GetToken',
            'username' => $this->username,
            'password' => $this->password
        ]);

        return $response->json();
    }

    public function getData()
    {
        $getToken = $this->getToken();

        if($getToken['error_code'] == 0) {
            $token = $getToken['data']['token'];
            $this->act['token'] = $token;

            $response = Http::post($this->urlFeeder, $this->act);

            return $response->json();
        } else {
            return $getToken;
        }
    }
}
