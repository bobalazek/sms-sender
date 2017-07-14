<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('homepage');

$app->error(
    function (
        \Exception $e,
        Request $request,
        $code
    ) use ($app) {
        if ($app['debug']) {
            return;
        }

        $templates = [
            'errors/'.$code.'.html.twig',
            'errors/'.substr($code, 0, 2).'x.html.twig',
            'errors/'.substr($code, 0, 1).'xx.html.twig',
            'errors/default.html.twig',
        ];

        return new Response(
            $app['twig']->resolveTemplate($templates)->render([
                'code' => $code,
            ]),
            $code
        );
    }
);
