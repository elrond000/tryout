<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Kassa\Database;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

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

$app->post('/api/sellers', function ($request, $response) {
    $data = (array)$request->getParsedBody();
    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $iban = $data['iban'] ?? '';
    if (!$name || !$email || !$iban) {
        $response->getBody()->write(json_encode(['error' => 'Missing fields']));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare('INSERT INTO sellers (name, email, iban_hash, iban_last4) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $email, hash('sha256', $iban), substr($iban, -4)]);
    $id = $pdo->lastInsertId();
    $response->getBody()->write(json_encode(['id' => (int)$id]));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/api/books', function ($request, $response) {
    $data = (array)$request->getParsedBody();
    $sellerId = $data['seller_id'] ?? null;
    $eventId = $data['event_id'] ?? null;
    $title = $data['title'] ?? '';
    $isbn = $data['isbn'] ?? '';
    $condition = $data['condition'] ?? '';
    $price = $data['price_cents'] ?? null;
    if (!$sellerId || !$eventId || !$title || $price === null) {
        $response->getBody()->write(json_encode(['error' => 'Missing fields']));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare('INSERT INTO books (seller_id, event_id, title, isbn, condition, price_cents) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$sellerId, $eventId, $title, $isbn, $condition, $price]);
    $id = $pdo->lastInsertId();
    $response->getBody()->write(json_encode(['id' => (int)$id]));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
