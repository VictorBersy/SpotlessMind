<?php

$app->get('/', function () use ($app) {
    return $app->redirect('en_US/');
});

$app->get('/{_locale}/', function () use ($app) {
    return $app['twig']->render('pages/home/home.twig');
});

/* ONLY FOR DEBUGGING */
if ($app['debug']) {
	$app->get('/debug/', function () use ($app) {
		require_once __DIR__.'/../controllers/debug.php';
		return '';
	});
}