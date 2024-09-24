<?php

use FastRoute\RouteCollector;
use App\http\Controllers\AuthController;
use App\http\Controllers\CartController;
use App\http\Controllers\ProductController;
use App\services\AuthService;

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {

    $r->addRoute('POST', '/api/login', [AuthController::class, ['method' => 'login', 'protected' => false]]);
    $r->addRoute('POST', '/api/register', [AuthController::class, ['method' => 'register', 'protected' => false]]);
    $r->addRoute('GET', '/api/user', [AuthController::class, ['method' => 'show', 'protected' => true]]);

    $r->addRoute('POST', '/api/product/create', [ProductController::class, ['method' => 'create', 'protected' => true]]);
    $r->addRoute('GET', '/api/products', [ProductController::class, ['method' => 'list', 'protected' => true]]);
    $r->addRoute('POST', '/api/product/update/{id}', [ProductController::class, ['method' => 'update', 'protected' => true]]);
    $r->addRoute('GET', '/api/product/delete/{id}', [ProductController::class, ['method' => 'delete', 'protected' => true]]);
    
    $r->addRoute('POST', '/api/cart/create', [CartController::class, ['method' => 'create', 'protected' => true]]);
    $r->addRoute('POST', '/api/cart/product/add', [CartController::class, ['method' => 'addProduct', 'protected' => true]]);
    $r->addRoute('GET', '/api/cart/{id}', [CartController::class, ['method' => 'getCart', 'protected' => true]]);
    $r->addRoute('GET', '/api/carts', [CartController::class, ['method' => 'getCarts', 'protected' => true]]);
    $r->addRoute('POST', '/api/cart/open/{id}', [CartController::class, ['method' => 'open', 'protected' => true]]);
    $r->addRoute('POST', '/api/cart/close/{id}', [CartController::class, ['method' => 'close', 'protected' => true]]);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

try{
if(strpos($uri, 'api/')) {
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
} catch (\Exception $e) {
    echo $e->getMessage();
}
