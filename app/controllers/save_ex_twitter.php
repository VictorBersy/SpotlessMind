<?php

// We created those tokens in callback_twitter.php
$twitter_session = $app['session']->get('twitter');
$twitter_session = $twitter_session['token_credentials']; 
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $twitter_session['oauth_token'], $twitter_session['oauth_token_secret']);


$user = $connection->get('users/show', // We check the user
	array(
		'screen_name'      => $_POST['ex_screen_name'], // From the form
		'include_entities' => 'false', // We don't need that shit
	)
);


if (isset($user->errors)) {
	$app['session']->set('twitter_ex_infos',
		array(
			'error' => array(
				'code'    => $user->errors[0]->code,
				'message' => $user->errors[0]->message,
			)
		)
	);
}
elseif (isset($user->id)) {
	$useful_infos = array(
		'id_str'                  => $user->id_str,
		'name'                    => $user->name,
		'screen_name'             => $user->screen_name,
		'description'             => $user->description,
		'profile_image_url_https' => str_replace('_normal', '', $user->profile_image_url_https),  
		);
	$app['session']->set('twitter_ex_infos', array('useful_infos' => $useful_infos));
}
else {
	$app['session']->set('twitter_ex_infos',
		array(
			'error' => array(
				'message' => 'Hmmm ... Ooops, something wrong happened. No idea what is it. Sorry. Love.',
			)
		)
	);
}
?>