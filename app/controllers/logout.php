<?php

// We set to null every sessions created
$app['session']->set('user', null);
$app['session']->set('twitter', null);
$app['session']->set('twitter_ex_infos', null);

?>