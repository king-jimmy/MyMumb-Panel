<?php
include '../inc/config.inc.php';
require 'Ice.php';
require '../inc/Murmur.php';
session_start();


if(!isset($_SESSION['host']))
{
	header('location: '.$MyConfig['http_adress']);
	die();
}
else
{
	$Password = array('secret' => $_SESSION['password']);
	$ICE = Ice_initialize();
	$ip = $_SESSION['host'];
	$port = $_SESSION['port'];
	$base = $ICE->stringToProxy("Meta:tcp -h $ip -p $port");
	$MasterServer = $base->ice_checkedCast("::Murmur::Meta")->ice_context($Password);
}



if(file_exists('../languages/'.$MyConfig['default_language'].'.php'))
{
	include '../languages/'.$MyConfig['default_language'].'.php';
}
else
	die("ERROR, LANGUAGE FILE DOSEN'T EXIST.");








echo '
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyMumb - Murmur Server Management </title>
    <link href="'. $MyConfig['http_adress'] .'/template/css/bootstrap.css" rel="stylesheet">
	<link href="'. $MyConfig['http_adress'] .'/template/css/default.css" rel="stylesheet">
	<link href="'. $MyConfig['http_adress'] .'/template/css/font-awesome.min.css" rel="stylesheet">
	<link href="'. $MyConfig['http_adress'] .'/template/css/jquery/jquery-ui-1.10.3.custom.css" rel="stylesheet"/>
	<link href="'. $MyConfig['http_adress'] .'/template/css/jquery/default.css" rel="stylesheet" />


    <script src="'. $MyConfig['http_adress'] .'/template/js/jquery.min.js"></script>
	<script src="'. $MyConfig['http_adress'] .'/template/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="'. $MyConfig['http_adress'] .'/template/js/bootstrap.min.js"></script>
	<script src="'. $MyConfig['http_adress'] .'/template/js/default.js"></script>
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="'. $MyConfig['http_adress'].'/mumble">'.$LANGUAGE['mumble_menu_mumbles'].'</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="https://github.com/dieonar/MyMumb-Panel">'.$LANGUAGE['mumble_menu_github'].'</a></li>
            <li><a href="'. $MyConfig['http_adress'] .'/?logout">'.$LANGUAGE['mumble_menu_logout'].'</a></li>
          </ul>
        </div>

      </div>
    </div>';

	$ModulesAllowed = array('overview' => true, 'config' => true, 'users' => true, 'viewer' => true, 'actions' => true);
	if(isset($_GET['display']) && !empty($ModulesAllowed[$_GET['display']]))
	{
		if(isset($_GET['server_id']))
		{
		$Server = $MasterServer->getServer(intval($_GET['server_id']))->ice_context($Password);
		$ServerPort = $Server->getConf('port');
		$ServerPort = (!empty($ServerPort))?$ServerPort:'64738';

		echo '<div class="container"><br>
				<h3>'. str_replace('{ID}', $Server->id(), $LANGUAGE['mumble_server_title']) .'</h3>
				<h1 style="text-align:center;">'. $LANGUAGE['overview_title'] .'</h1>
				<div class="well" style="width:80%; margin: 0 auto">
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-4">'. $LANGUAGE['overview_hostname'] .' </div>
						<div class="col-sm-5">'. ($_SESSION['host'] == '127.0.0.1' ? $_SERVER['SERVER_ADDR'] : $_SESSION['host']) .'</div>
					</div>
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-4">'. $LANGUAGE['overview_port'] .' </div>
						<div class="col-sm-5">'. $ServerPort .'</div>
					</div>
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-4">'. $LANGUAGE['overview_slots'] .'</div>
						<div class="col-sm-5">'. $Server->getConf('users') .' Slots</div>
					</div>

					<div class="row">
						<form action="" method="POST" id="newSUPW">
							<div class="col-sm-3"></div>
							<div class="col-sm-4">'. $LANGUAGE['overview_superpass'] .' </div>
							<div class="col-sm-5">'. $Server->getConf('SuperUserPassword') .'<input type="hidden" name="type" value="newSuperPassword"><span style="position:absolute; margin-left:20px;" class="label label-success"><a href="#" onclick="newSUPW.submit();" style="color:#FFF;">Régénérer</span></a></div>
						</form>
					</div>
					<center><br>
						<a href="#" onclick="$(\'#delete-server\').dialog(\'open\'); return false;" ><img src="'. $MyConfig['http_adress'] .'/template/images/delete.png" height="25" width="25">'. $LANGUAGE['overview_delete'] .'</a>
					</center>
				</div>
				<div class="well" style="width:700px; margin: 0 auto; margin-top:5px;">
					<center>
						<table style="text-align: center; border:0 !important;" border="0" cellpadding="2" cellspacing="2">
						  <tbody>
							<tr>
							  <td style="width:33%"><a href="'. $MyConfig['http_adress'] . '/mumble/server/'. $_GET['server_id'] .'/start" class="custom-metro cm-green"><i class="fa fa-play-circle"></i> '. $LANGUAGE['action_start'] .'</a></td>
							  <td style="width:33%"><a href="'. $MyConfig['http_adress'] . '/mumble/server/'. $_GET['server_id'] .'/restart" class="custom-metro cm-blue"><i class="fa fa-repeat"></i> '. $LANGUAGE['action_restart'] .'</a></td>
							  <td style="width:33%"><a href="'. $MyConfig['http_adress'] . '/mumble/server/'. $_GET['server_id'] .'/stop" class="custom-metro cm-red"><i class="fa fa-square"></i> '. $LANGUAGE['action_stop'] .'</a></td>
							</tr>
							<tr>
							  <td><a href="'. $MyConfig['http_adress'] . '/mumble/server/'. $_GET['server_id'] .'/config" class="custom-metro cm-brown"><i class="fa fa-file-text"></i> '. $LANGUAGE['action_config'] .'</a></td>
							  <td><a href="'. $MyConfig['http_adress'] . '/mumble/server/'. $_GET['server_id'] .'/users" class="custom-metro cm-brown"><i class="fa fa-users"></i> '. $LANGUAGE['action_users'] .'</a></td>
							  <td><a href="'. $MyConfig['http_adress'] . '/mumble/server/'. $_GET['server_id'] .'/viewer" class="custom-metro cm-brown"><i class="fa fa-eye"></i> '. $LANGUAGE['action_viewer'] .'</a></td>
							</tr>
						  </tbody>
						</table>
					</center>
				</div>
		';
		}


		if(file_exists('_'.$_GET['display'].'.php'))
			include '_'.$_GET['display'].'.php';

		echo '</div>';
	}
	else
	{
		if(file_exists('_servers.php'))
			include '_servers.php';
		else
			die('ERROR');
	}


	echo '

		<div id="delete-server" class="floatingdialog">
			<h3 class="center">'. $LANGUAGE['overview_delete_title'] .'</h3>
			<p style="text-align: center;"></p>

				<form action="'. $MyConfig['http_adress'] . '/mumble/delete-server" method="post" class="center" id="deleteserver">
					<input type="hidden" name="server_id" value="'.$Server->id().'">
					<div style="width: 500px; text-align:center;"><a href="#" onclick="deleteserver.submit();" class="custom-metro cm-green cm-auto">'. $LANGUAGE['overview_delete_btn_yes'] .'</a> <a href="#" onclick="$(\'#delete-server\').dialog(\'close\'); return false;"class="custom-metro cm-red cm-auto">'. $LANGUAGE['overview_delete_btn_no'] .'</a></div>
				</form>

		</div>
		<script type="text/javascript">
			newFlexibleDialog("delete-server", 550);
		</script>

  </body>
</html>
';

?>
