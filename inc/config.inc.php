<?php

	$MyConfig = array();


	$MyConfig['default_host'] = '127.0.0.1'; //Ip of your Mumble Server. If its the same Server no need to change it.
	$MyConfig['default_port'] = 6502; //The Port of your Mumble Server

	$MyConfig['ICE_Password'] = 'icesecret'; //The Password used in the mumble-server.ini 

	$MyConfig['default_language'] = 'en_EN'; //Change the Language currently supported en_EN fr_FR de_DE

	$MyConfig['use_login_protection'] = false; //Change to true if using the below and not the ICE Secret
	$MyConfig['Username'] = 'Username';
	$MyConfig['Password'] = 'MD5 Decrypted Password';

	
	
	/*
	**	Edit the following line ONLY if you have trouble for connection
	**	Comment the first line and uncomment the other.
	*/
		$MyConfig['MetaConnection'] = "Meta:tcp";
		//$MyConfig['MetaConnection'] = "Meta -e 1.0:tcp";
?>
