<?php
var_dump($_POST);
if (isset($_POST['yes'])) {
	$twitter_session = $app['session']->get('twitter');
	$twitter_session = $twitter_session['token_credentials']; 
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $twitter_session['oauth_token'], $twitter_session['oauth_token_secret']);

	foreach ($app['session']->get('favorites_from_ex') as $key => $favorite) {
		$connection->post('favorites/destroy', array('id' => $favorite->id_str));
	}
	$toReturn = $app->redirect($app['url_generator']->generate('home'));
}
elseif(isset($_POST['see'])) {
	$toReturn = $app->redirect($app['url_generator']->generate('see_favorites_from_ex'));
}
elseif(isset($_POST['no'])) {
	$app['session']->set('favorites_from_ex', null);
	$toReturn = $app->redirect($app['url_generator']->generate('home'));
}
 
?>