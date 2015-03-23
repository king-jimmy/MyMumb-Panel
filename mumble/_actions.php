<?php

	function random_chars($n)
	{
		$alfa= 'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ0123456789';
		return substr(str_shuffle($alfa),0,$n);
	}	

	if(isset($_GET['start']))
	{
		if($Server->isRunning())
			echo '<br><center><div class="alert alert-danger">'. $LANGUAGE['action_start_error'] .'</div></center>';
		else
		{
			echo '<br><center><div class="alert alert-success">'. $LANGUAGE['action_start_success'] .'</div></center>';
			$Server->start();
		}
	}
	
	if(isset($_GET['restart']))
	{
		echo '<br><center><div class="alert alert-success">'. $LANGUAGE['action_restart_success'] .'</div></center>';
		if($Server->isRunning())
		{
			$Server->stop();
		}
		$Server->start();
	}

	if(isset($_GET['resetsupwd']))
	{
		$pw = random_chars(8);
		$Server->setConf('SuperUserPassword', $pw);
		$Server->setSuperuserPassword($pw);
		echo '<script language="javascript">
				document.getElementById("superuser_password").innerHTML = "'.$pw.'"; 
			  </script>';
		echo '<br><center><div class="alert alert-success">'. $LANGUAGE['overview_sp_changed'] .'</div></center>';
	}
	
	if(isset($_GET['stop']))
	{
		if($Server->isRunning())
		{
			echo '<br><center><div class="alert alert-success">'. $LANGUAGE['action_stop_success'] .'</div></center>';
			$Server->stop();
		}
		else
			echo '<br><center><div class="alert alert-danger">'. $LANGUAGE['action_stop_error'] .'</div></center>';
	}	
	
	function portIsUsed($argPort)
	{
		global $MasterServer, $Password;
		$Servers = $MasterServer->getAllServers();
		foreach($Servers as $Server) 
		{
			$Server = $Server->ice_context($Password);	
			$ServerPort = $Server->getConf('port');
									
			if($ServerPort == $argPort)
				return true;
		}
		return false;
	}
					
	if(isset($_GET['create-server']))
	{
		$serverName = $_POST['serverName'];
		$serverSlots = $_POST['serverSlots'];
		$serverPort = $_POST['serverPort'];	
			
		if(!portIsUsed($serverPort))
		{
			$Password = array('secret' => $_SESSION['password']);		
			$newServer = $MasterServer->newServer();
			$newServer = $newServer->ice_context($Password);
			$newServerID = $newServer->id();

			$newServer = $MasterServer->getServer($newServerID)->ice_context($Password);
			
			if($serverName == '')
			{
				$serverName = str_replace('{ID}', $newServerID, $LANGUAGE['mumble_server_title']);
				$newServer->setConf('registername', $serverName);
			}
			else
				$newServer->setConf('registername', '' . $serverName);
							
			$newServer->setConf('users', $serverSlots);
			$newServer->setConf('port', ''.$serverPort);
			
			$pw = random_chars(8);
			$newServer->setConf('SuperUserPassword', $pw);
			$newServer->setSuperuserPassword($pw);
			

			header('location: '.$MyConfig['http_adress'].'/mumble/index.php?server_id='.$newServerID.'&display=overview');
		}	
		else
		{
			header('location: '.$MyConfig['http_adress'].'/mumble');
		}
	}
	
	if(isset($_GET['delete-server']))
	{
		$ServerToDelete = $_POST['server_id'];
		$Server = $MasterServer->getServer(intval($ServerToDelete))->ice_context($Password);

		if($Server->isRunning())
			$Server->stop();
			
		$Server->delete();
			
		header('location: '.$MyConfig['http_adress'].'/mumble');
	}
	
	
	
?>
