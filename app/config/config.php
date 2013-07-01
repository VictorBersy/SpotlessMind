<?php

include('keys_twitter.php');

$app['debug'] = true;

use Symfony\Component\Translation\Loader\YamlFileLoader;

/* Register our services from Silex */
 /* Twig Service Provider */
		$app->register(new Silex\Provider\TwigServiceProvider(), array(
			'twig.path'	=> __DIR__.'/../views/',
		));

	/* Session Service Provider */
		$app->register(new Silex\Provider\SessionServiceProvider());

	/* Swiftmailer Service Provider */
		$app->register(new Silex\Provider\SwiftmailerServiceProvider());

	/* URL Generator Service Provider */
		$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

	/* Translation Service Provider */
		$app->register(new Silex\Provider\TranslationServiceProvider(), array(
				'locale_fallback' => 'en_US',
				'locale'          => 'en_US',
		));

	/* Translation Service Provider */
		$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
				$translator->addLoader('yaml', new YamlFileLoader());

				$translator->addResource('yaml', __DIR__.'/../locales/en_US.yml', 'en_US');
				$translator->addResource('yaml', __DIR__.'/../locales/fr_FR.yml', 'fr_FR');

				return $translator;	
		}));

/* Useful for home view */
$done = array('first'  => false, 'second' => false, 'third'  => false, 'fourth' => false);

$user = $app['session']->get('user');
if (isset($user['twitter'])) { // User is logged in, first step : ok
	$done['first'] = true;
}

$twitter_ex_infos = $app['session']->get('twitter_ex_infos');
if ( (!isset($twitter_ex_infos['error'])) && (isset($twitter_ex_infos['useful_infos'])) ) { // No error, and useful_infos is set, I think it's okay
	$done['second'] = true;
}