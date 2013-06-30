<?php

$app->get('/', function () use ($app) {
    return $app->redirect('en_US/');
})
->bind('root');

$app->get('/{_locale}/', function () use ($app) {
    return $app['twig']->render('pages/home/home.twig');
})
->bind('home');

/* Twitter */
		$app->get('/{_locale}/redirect/twitter/', function () use ($app) {
			require_once __DIR__.'/../controllers/redirect_twitter.php';
			return $app->redirect($redirect_url); // var from controllers/redirect_twitter.php
		})
		->bind('redirect_twitter');

		$app->get('/{_locale}/callback/twitter/', function () use ($app) {
			require_once __DIR__.'/../controllers/callback_twitter.php';
			return $app->redirect($app['url_generator']->generate('home'));
		})
		->bind('callback_twitter');
/* End Twitter */

/* ONLY FOR DEBUGGING */
if ($app['debug']) {
	$app->get('/{_locale}/debug/', function () use ($app) {
		require_once __DIR__.'/../controllers/debug.php';
		return '';
	});
}