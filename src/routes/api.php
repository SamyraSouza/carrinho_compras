<?php

use FastRoute\RouteCollector;
use Juninho\CarrinhosCompras\http\Controllers\AuthController;
use Juninho\CarrinhosCompras\http\Controllers\CartController;
use Juninho\CarrinhosCompras\http\Controllers\ProductController;

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
 
    $r->addRoute('POST', '/carrinho_compras/api/login', [AuthController::class, 'login']);
    $r->addRoute('POST', '/carrinho_compras/api/register', [AuthController::class, 'register']);
    $r->addRoute('GET', '/carrinho_compras/api/user/{id}', [AuthController::class, 'show']);

    $r->addRoute('POST', '/carrinho_compras/api/product/create', [ProductController::class, 'create']);
    $r->addRoute('POST', '/carrinho_compras/api/product/{id}', [ProductController::class, 'update']);

    $r->addRoute('POST', '/carrinho_compras/api/cart/product/add', [CartController::class, 'addProduct']);
    $r->addRoute('GET', '/carrinho_compras/api/cart/{id}', [CartController::class, 'getCart']);
    $r->addRoute('GET', '/carrinho_compras/api/carts', [CartController::class, 'getCarts']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

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
            $method = $handler[1];

            call_user_func_array([$controller, $method], [$vars, $requestData]);
        } else {
            call_user_func_array($handler, [$vars]);
        }
        break;
}