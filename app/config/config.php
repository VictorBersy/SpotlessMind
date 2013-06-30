<?php

$app['debug'] = true;

use Symfony\Component\Translation\Loader\YamlFileLoader;

/* Register our services from Silex */
 /* Twig Service Provider */
		$app->register(new Silex\Provider\TwigServiceProvider(), array(
			'twig.path'      => __DIR__.'/../views/',
		));

	/* Session Service Provider */
		$app->register(new Silex\Provider\SessionServiceProvider());

	/* Swiftmailer Service Provider */
		$app->register(new Silex\Provider\SwiftmailerServiceProvider());

	/* Swiftmailer Service Provider */
		$app->register(new Silex\Provider\TranslationServiceProvider(), array(
				'locale_fallback' => 'en_US',
		));

	/* Translation Service Provider */
		$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
				$translator->addLoader('yaml', new YamlFileLoader());

				$translator->addResource('yaml', __DIR__.'/../locales/en_US.yml', 'en_US');
				$translator->addResource('yaml', __DIR__.'/../locales/fr_FR.yml', 'fr_FR');

				return $translator;	
		}));