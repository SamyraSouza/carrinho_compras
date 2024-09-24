<?php 

use FastRoute\RouteCollector;
use App\services\AuthService;

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', function () {
        include './resources/views/home.html';
        exit();
    });

    $r->addRoute('GET', '/docs', function () {
        include './resources/views/docs.html';
        exit();
    });

    $r->addRoute('GET', '/contact', function () {
        include './resources/views/contact.html';
        exit();
    });
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if(!strpos($uri, 'api/')) {
    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }

    $uri = rawurldecode($uri);
    
    $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            echo json_encode(['status' => 'error', 'message' => 'Route not found']);
            break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            break;
        case FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2];
            $requestData = ($httpMethod === 'POST') ? $_POST : $_GET;
    
            if (is_array($handler) && count($handler) == 2) {
                $controller = new $handler[0]();
                $method = $handler[1]['method'];
                $protected = $handler[1]['protected'];
                $headers = getallheaders();
    
                if ($protected && !isset($headers['Authorization'])) {
                    echo json_encode(['status' => 'error', 'message' => 'Não autorizado']);
                    exit();
                }
                if (isset($headers["Authorization"])) {
                    $token = explode(" ", $headers["Authorization"]);
                    $requestData["user_token"] = $token[1];
                    $verify = new AuthService();
                    $validated = $verify->verifyTokenValidated($requestData["user_token"]);
    
                    if(!$validated){
                        echo json_encode(['status' => 'error', 'message' => 'Não autorizado']);
                        exit();
                    }
                }
                call_user_func_array([$controller, $method], [$vars, $requestData]);
            } else {
                call_user_func_array($handler, [$vars]);
            }
            break;
    }
}
