<?php
namespace App\Http\Controllers;


use GuzzleHttp\Client;

class ApiService
{
    private $client;
    private $token;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://postulaciones.solutoria.cl/api/'
        ]);

        // Obtener token
        $response = $this->client->post('acceso/', [
            'json' => [
                'userName' => 'niximunozr@gmail.com',
                'flagJson' => true
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        $this->token = $data['token'];
    }

    public function getIndicadores()
    {
        $response = $this->client->get('indicadores/', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        return $data;
    }
}
