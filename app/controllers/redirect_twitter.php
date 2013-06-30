<?php

// We build a TwitterOAuth object using credentials specified in app/config/keys_twitter.php
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

// We ask for temporary credentials
$temporary_credentials = $connection->getRequestToken();
// and store them in session called twitter
$app['session']->set('twitter', array('temporary_credentials' => $temporary_credentials));

// We use it to get an Authorize URL
$redirect_url = $connection->getAuthorizeURL($temporary_credentials);

// Now, we need to redirect the user to this URL.
// I did it with the native $app->redirect function from Silex
// Check the routes.php file if you want to see how. 

?>