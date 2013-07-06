<?php

if (isset($_POST['yes'])) {
	// Grab favorites tweets from this bitch

	// Connect to the API
	$twitter_session = $app['session']->get('twitter');
	$twitter_session = $twitter_session['token_credentials']; 
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $twitter_session['oauth_token'], $twitter_session['oauth_token_secret']);

	// Get useful stuff from session about the ex
	$twitter_ex_infos = $app['session']->get('twitter_ex_infos');
	$twitter_ex_infos = $twitter_ex_infos['useful_infos'];

	// about the logged user
	$twitter_logged_infos = $app['session']->get('user');
	$twitter_logged_infos = $twitter_logged_infos['twitter']['useful_infos'];

	// and the rate limits
	$rate_limit_status = $connection->get('application/rate_limit_status', array('resources' => 'favorites'));
	var_dump($rate_limit_status->resources->favorites->{'/favorites/list'}->remaining);
	var_dump(date('H:i:s', $rate_limit_status->resources->favorites->{'/favorites/list'}->reset - time() - 3600));
	$rate_limit_favorites = $rate_limit_status->resources->favorites->{'/favorites/list'}->remaining;

	// We need to know how many request we have to do
		// Setting some vars
		$nb_favorites = $twitter_logged_infos['favourites_count'];
		// If we have 927 favorites
		$remainder    = ($nb_favorites % 200);
		$quotient     = floor($nb_favorites / 200);

		if ($rate_limit_favorites > 0) {
			while ($nb_favorites >= 200) {
				$params = (isset($max_id)) ? 
					array('include_entities' => false, 'count' => 200, 'max_id' => $max_id) : 
					array('include_entities' => false, 'count' => 200);

				foreach ($connection->get('favorites/list', $params) as $key => $tweet_object) {
					$every_favorites[] = $tweet_object;
				}
				$max_id = end($every_favorites)->id_str;
				$nb_favorites = $nb_favorites - 200;
			}
		}
		else {
			var_dump($rate_limit_favorites);
			throw new Exception("Rate limits exceed", 1);
		}

		foreach ($every_favorites as $key => $tweet_object) {
			if ($tweet_object->user->screen_name == $twitter_ex_infos['screen_name']) {
				$favorites_from_ex[] = $tweet_object;
			}
		}

		if (isset($favorites_from_ex)) {
			$app['session']->set('favorites_from_ex',	$favorites_from_ex);
		}
}
else {
	// If it's not this one, we reset informations about this ex
	$app['session']->set('twitter_ex_infos', null);
}

?>