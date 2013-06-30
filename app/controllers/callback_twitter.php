<?php

// We set this var in redirect_twitter.php
$twitter_session = $app['session']->get('twitter');
$twitter_session = $twitter_session['temporary_credentials']; 

// We use temporary credentials (generated in redirect_twitter.php) to build a new TwitterOAuth object
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $twitter_session['oauth_token'], $twitter_session['oauth_token_secret']);

// Now we ask Twitter for long lasting token credentials.
$token_credentials = $connection->getAccessToken($_REQUEST['oauth_verifier']);
// We store them to use it later, when we'll make requests
$app['session']->set('twitter', array('token_credentials' => $token_credentials));

?>