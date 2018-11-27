<?php
	
	$w_routes = array(
		['GET', '/', 'Default#home', 'default_home'],
		['POST', '/newgame', 'Default#newGame', 'newGame'],
		['POST', '/shoot', 'Default#shoot', 'shoot'],
	);