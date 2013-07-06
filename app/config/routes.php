<?php

$app->get('/', function () use ($app) {
    return $app->redirect('en_US/');
})
->bind('root');

$app->get('/{_locale}/', function () use ($app, $done, $user, $twitter_ex_infos, $favorites_from_ex) {
		$forTwig = array(
			'done'              => $done,
			'user'              => $user,
			'twitter_ex_infos'  => $twitter_ex_infos,
			'favorites_from_ex' => $favorites_from_ex,
		);
    return $app['twig']->render('pages/home/home.twig', $forTwig);
})
->bind('home');

/* Twitter */
		$app->get('/twitter/redirect/', function () use ($app) {
			require_once __DIR__.'/../controllers/redirect_twitter.php';
			return $app->redirect($redirect_url); // var from controllers/redirect_twitter.php
		})
		->bind('redirect_twitter');

		$app->get('/twitter/callback/', function () use ($app) {
			require_once __DIR__.'/../controllers/callback_twitter.php';
			return $app->redirect($app['url_generator']->generate('home'));
		})
		->bind('callback_twitter');

		$app->post('/twitter/save_ex/', function () use ($app) {
			require_once __DIR__.'/../controllers/save_ex_twitter.php';
			return $app->redirect($app['url_generator']->generate('home'));
		})
		->bind('save_ex_twitter');

		$app->post('/twitter/is/your/ex/', function () use ($app) {
			require_once __DIR__.'/../controllers/is_your_ex_twitter.php';
			return $app->redirect($app['url_generator']->generate('home'));
		})
		->bind('is_your_ex_twitter');

		$app->post('/twitter/see/favorites/from/ex/', function () use ($app, $favorites_from_ex) {
			return $app['twig']->render('pages/home/home.twig', $favorites_from_ex);
		})
		->bind('see_favorites_from_ex');
/* End Twitter */


$app->get('/{_locale}/logout/', function () use ($app) {
		require_once __DIR__.'/../controllers/logout.php';
		return $app->redirect($app['url_generator']->generate('home'));
})
->bind('logout');


/* ONLY FOR DEBUGGING */
if ($app['debug']) {
	$app->get('/{_locale}/debug/', function () use ($app) {
		require_once __DIR__.'/../controllers/debug.php';
		return '';
	});
}