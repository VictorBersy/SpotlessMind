<?php
	/* Useful for home view */
	$done = array('first'  => false, 'second' => false, 'third'  => false, 'fourth' => false);

	$user = $app['session']->get('user');
	if (isset($user['twitter'])) { // User is logged in, first step : ok
		$done['first'] = true;
	}

	$twitter_ex_infos = $app['session']->get('twitter_ex_infos');
	if ( (!isset($twitter_ex_infos['error'])) && (isset($twitter_ex_infos['useful_infos']) && ($done['first'])) ) { // No error, and useful_infos is set, I think it's okay
		$done['second'] = true; // Second step is done
	}

	$favorites_from_ex = $app['session']->get('favorites_from_ex');
	if ( (!is_null($favorites_from_ex)) && ($done['second']) ) {
		$done['third'] = true; // Third step is done
	}
?>