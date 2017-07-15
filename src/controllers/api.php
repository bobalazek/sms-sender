<?php

use Symfony\Component\HttpFoundation\Request;

$app->get('/api/ping', function (Request $request) use ($app) {
    $token = $request->query->get('token');
    if ($token !== $app['config.token']) {
        return $app->json([
            'error' => [
                'message' => 'Invalid token.',
            ],
        ]);
    }
    
    return $app->json([
        'success' => true,
    ]);
})->bind('api.ping');

$app->get('/api/send', function (Request $request) use ($app) {
    $token = $request->query->get('token');
    if ($token !== $app['config.token']) {
        return $app->json([
            'error' => [
                'message' => 'Invalid token.',
            ],
        ]);
    }

    // Data
    $to = $request->query->get('to');
    $message = $request->query->get('message');

    // Validation
    if (empty($to)) {
        return $app->json([
            'error' => [
                'message' => 'Please specify the "to" parameter.',
            ],
        ]);
    }
    if (empty($message)) {
        return $app->json([
            'error' => [
                'message' => 'Please specify the "message" parameter.',
            ],
        ]);
    }
    
    $app['db']->insert(
        'smses',
        [
            'to' => $to,
            'message' => $message,
            'status' => 'queued',
            'created_at' => date(DATE_ATOM),
            'updated_at' => date(DATE_ATOM),
        ]
    );

    return $app->json([
        'success' => true,
    ]);
})->bind('api.send');

$app->get('/api/queue/next', function (Request $request) use ($app) {
    $token = $request->query->get('token');
    if ($token !== $app['config.token']) {
        return $app->json([
            'error' => [
                'message' => 'Invalid token.',
            ],
        ]);
    }

    $statement = $app['db']->prepare(
        'SELECT * FROM smses
            WHERE status="queued"
            ORDER BY created_at ASC'
    );
    $statement->execute();
    $smses = $statement->fetchAll();

    return $app->json([
        'success' => true,
        'data' => !empty($smses)
            ? $smses[0]
            : null,
    ]);
})->bind('api.queue.next');

$app->get('/api/process/{id}', function ($id, Request $request) use ($app) {
    $token = $request->query->get('token');
    if ($token !== $app['config.token']) {
        return $app->json([
            'error' => [
                'message' => 'Invalid token.',
            ],
        ]);
    }

    $app['db']->update(
        'smses',
        [
            'status' => 'processed',
            'updated_at' => date(DATE_ATOM),
            'processed_at' => date(DATE_ATOM),
        ],
        [
            'id' => $id,
        ]
    );

    return $app->json([
        'success' => true,
    ]);
})->bind('api.process');
