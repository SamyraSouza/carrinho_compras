<?php

namespace App\http\Controllers;

use GuzzleHttp\Psr7\Response;

abstract class Controller
{
    public function respondsWith($status, $message, $data =[]){
        $response = new Response($status, ['Content-Type' => 'application/json'], json_encode([
            'success' => $status>=200 && $status<=300 ? true : false,
            'message' => $message,
            'data' => $data
        ]));
        
        // Enviando a resposta
        header('HTTP/1.1 ' . $response->getStatusCode());
        foreach ($response->getHeaders() as $name => $values) {
            header("$name: " . implode(", ", $values));
        }
        echo $response->getBody();
    }
}
