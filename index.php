<?php

	require 'vendor/autoload.php';

	$exact = new Exact\Exact('b81cc4de-d192-400e-bcb4-09254394c52a', 'n3G7KAhcv8OH');


	echo $exact->getAuthUrl('www.google.nl');