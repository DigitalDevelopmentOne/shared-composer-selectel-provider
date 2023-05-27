<?php

namespace SelectelTransmitter;

use Illuminate\Support\Facades\Http;

class Transmitter
{
    private const URL = 'https://api.selcdn.ru';
    private const VERSION = 'v1';
    private const AUTH = 'auth/v1.0';

    public string $user;
    public string $password;
    public string $container;
    public string $account;

    private function authUrl(): string {
        return Self::URL . '/' . Self::AUTH;
    }

    private function fileUploadUrl(): string {
        return Self::URL . '/' . Self::VERSION . '/' . $this->account .'/' . $this->container;
    }

    public function __construct(string $user, string $password, string $container, string $account)
    {
        $this->user = $user;
        $this->password = $password;
        $this->container = $container;
        $this->account = $account;
    }

    public function getToken(): string|null
    {
        $request_headers = [
            'X-Auth-User' => $this->user,
            'X-Auth-Key' => $this->password
        ];
        $response = Http::withHeaders($request_headers)->get($this->authUrl());

        if ($response->status() !== 204){
            return null;
        }

        $token = $response->headers()['X-Auth-Token'][0];
        return $token;
    }

    public function saveFile(
        string $inputPath,
        string $inputFileName,
        string|null $outputFileName = null,
        string|null $selectelToken = null
    ) : bool
    {

        $outputFile = $outputFileName ?? $inputFileName;
        $token = $selectelToken ?? $this->getToken();

        $url = $this->fileUploadUrl() . '/' . $outputFile ;

        $request_headers = [
            'X-Auth-Token:' . $token
        ];

        $inputFile = $inputPath . '/'. $inputFileName;
        $fileOpen = fopen ($inputFile, "rb");
        $filesize = filesize($inputFile);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, $request_headers) ;
        curl_setopt ($ch, CURLOPT_PUT, 1) ;
        curl_setopt ($ch, CURLOPT_INFILE, $fileOpen);
        curl_setopt($ch, CURLOPT_INFILESIZE, $filesize);
        curl_exec($ch);

        if (curl_errno($ch)) {
            dump(curl_error($ch));
            return false;
        }
        curl_close($ch);
        return true;
    }

}
