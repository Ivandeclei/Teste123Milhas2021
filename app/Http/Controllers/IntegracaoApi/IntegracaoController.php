<?php

namespace App\Http\Controllers\IntegracaoApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use PhpParser\Node\Stmt\TryCatch;

class IntegracaoController extends Controller
{
    const BASE_URL_API = "http://prova.123milhas.net/api/flights/";

    public function dadosApi()
    {
        try{

            $response = $this->acessoApi();

            $response = json_decode($response->getBody()->getContents());

            return $response;

        }catch(GuzzleException $e){

            if ($e->hasResponse()) {
                $e = [
                    'messages' => $e->getResponse()->getReasonPhrase(),
                    'statusCode'  => $e->getResponse()->getStatusCode()
                ];

            }else{
                $e = ['message' => "Erro inesperado ao acessar os dados."];
            }

            return $e;
        }

    }

    public function acessoApi(){
        try {
            $client = new Client();

            $url = self::BASE_URL_API;
            $response = $client->request('GET', $url);

            return $response;
        } catch (GuzzleException $e) {
            if ($e->hasResponse()) {
                $e = [
                    'message' => $e->getResponse()->getReasonPhrase(),
                    'statusCode'  => $e->getResponse()->getStatusCode()
                ];

            }else{
                $e = ['message' => "Erro inesperado ao realizar conexao."];
            }

          return $e;
        }
    }
}
