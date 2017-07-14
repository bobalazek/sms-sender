<?php

use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Schema\Table;

$app->get('/database/create', function (Request $request) use ($app) {
    $token = $request->query->get('token');
    if ($token !== $app['config.token']) {
        return $app->json([
            'error' => [
                'message' => 'Invalid token.',
            ],
        ]);
    }

    $schema = $app['db']->getSchemaManager();

    if (!$schema->tablesExist('smses')) {
        $smsesTable = new Table('smses');

        $smsesTable->addColumn(
            'id',
            'integer',
            [
                'unsigned' => true,
                'autoincrement' => true,
            ]
        );
        $smsesTable->setPrimaryKey(['id']);

        $smsesTable->addColumn('status', 'string', ['length' => 32]);
        $smsesTable->addColumn('from', 'string', ['length' => 255]);
        $smsesTable->addColumn('to', 'string', ['length' => 255]);
        $smsesTable->addColumn('message', 'text');

        $smsesTable->addColumn('created_at', 'string', ['length' => 32]);
        $smsesTable->addColumn('updated_at', 'string', ['length' => 32]);
        $smsesTable->addColumn('processed_at', 'string', ['length' => 32]);

        $schema->createTable($smsesTable);
    }

    return $app->json([
        'success' => true,
    ]);
})->bind('database.create');

$app->get('/database/drop', function (Request $request) use ($app) {
    $token = $request->query->get('token');
    if ($token !== $app['config.token']) {
        return $app->json([
            'error' => [
                'message' => 'Invalid token.',
            ],
        ]);
    }

    $app['db']->query('DROP TABLE smses');

    return $app->json([
        'success' => true,
    ]);
})->bind('database.drop');
