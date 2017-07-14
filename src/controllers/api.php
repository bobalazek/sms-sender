<?php

use Symfony\Component\HttpFoundation\Request;

$app->get('/api/sms', function () use ($app) {
    $token = $request->query->get('token');
    if ($token !== $app['config.token']) {
        return $app->json([
            'error' => [
                'message' => 'Invalid token.',
            ],
        ]);
    }

    // Data
    $from = $request->query->get('from');
    $to = $request->query->get('to');
    $message = $request->query->get('message');

    // Validation
    if (empty($from)) {
        return $app->json([
            'error' => [
                'message' => 'Please specify the "from" parameter.',
            ],
        ]);
    }
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
            'from' => $from,
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
})->bind('api.send_sms');

$app->get('/api/process', function () use ($app) {
    $token = $request->query->get('token');
    if ($token !== $app['config.token']) {
        return $app->json([
            'error' => [
                'message' => 'Invalid token.',
            ],
        ]);
    }

    // TODO

    return $app->json([
        'success' => true,
    ]);
})->bind('api.process');
