<?php

namespace App\Utils;

use Google\Client;
use Google\Service\Oauth2;
use Google\Service\Oauth2\Userinfo;
use GuzzleHttp\Client as GuzzleHttpClient;

class GoogleClient
{
    public readonly Client $client;
    private Userinfo $data;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function init()
    {
        $guzzleCliente = new GuzzleHttpClient([
            "curl" => [CURLOPT_SSL_VERIFYPEER => false]
        ]);
        $this->client->setHttpClient($guzzleCliente);
        $this->client->setClientId($_ENV["GOOGLE_CLIENT_ID"]);
        $this->client->setClientSecret($_ENV["GOOGLE_SECRET_KEY"]);
        $this->client->setRedirectUri($_ENV["GOOGLE_REDIRECT_URI"]);
        $this->client->addScope("email");
        $this->client->addScope("profile");
    }

    public function generateAuthLink()
    {
        return $this->client->createAuthUrl();
    }

    public function authorized()
    {
        if (isset($_GET["code"])) {
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET["code"]);
            $this->client->setAccessToken($token["access_token"]);

            $googleService = new Oauth2($this->client);
            $this->data = $googleService->userinfo->get();
            // dd($this->data);
            return true;
        }

        return false;
    }

    public function getData()
    {
        return $this->data;
    }
}
