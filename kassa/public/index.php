<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/health', function ($request, $response) {
    $response->getBody()->write('OK');
    return $response;
});

$app->get('/api/events', function ($request, $response) {
    $data = [
        ['id' => 1, 'name' => 'Sample Event']
    ];
    $payload = json_encode($data, JSON_PRETTY_PRINT);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
