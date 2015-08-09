<?php

	function countServerAndSlots()
	{
		global $MasterServer, $Password;
		$Servers = $MasterServer->getAllServers();

		$Count = array();
		$Count['Servers'] = 0;
		$Count['Slots'] = 0;
		$Count['slotsps'] = 0;
		$Count['users'] = 0;
		
		foreach($Servers as $Server) {
			$Server = $Server->ice_context($Password);
			$Count['Servers']++;
			$Count['Slots'] = $Count['Slots'] + $Server->getConf('users');
			$Count['slotsps'] = $Server->getConf('users');
			if($Server->isRunning()){
			$Count['users'] = count($Server->getUsers());
			}
 		}
		return $Count;
	}
	$Count = countServerAndSlots();
	

	
echo '

<div class="top">
		<div class="left" style="width: 80%;">
			<h5 style="font-size:18px; padding-top:8px;">'. str_replace('{SERVER_INFOS}', $_SESSION['host'].':'. $_SESSION['port'], $LANGUAGE['servers_connectedto']) .'</h5>
		</div>
		<div class="right" style="width: 20%;">
			<div class="row">
				<h5>
					<div class="col-sm-4">'. $LANGUAGE['servers_countservers'] .'</div>
					<div class="col-sm-4"><b>'. $Count['Servers'] .'</b> / ∞ </div>
				</h5>
			</div>
			<div class="row">
				<h5>
					<div class="col-sm-4" style="text-align:right;">'. $LANGUAGE['servers_countslots'] .'</div>
					<div class="col-sm-4"><b>'. $Count['Slots'] .'</b> / ∞ </div>
				</h5>
			</div>

		</div>
		<div class="clear"></div>
	</div>
	<div class="servers"><br>
		<div class="container" stlyle="padding-top:10px !important; ">';
		
		$Servers = $MasterServer->getAllServers();
		foreach($Servers as $Server) 
		{
			$Server = $Server->ice_context($Password);
		
		echo '
			<div class="server" onclick="window.location.href=\'./index.php?server_id='. $Server->id() .'&display=overview' .'\';">
						<span style="font-size: 16px; font-weight: bold; display: block; margin-bottom: 5px; text-align:center;">'. $Server->getConf('registername') .'</span>
						<center><img src="../template/images/mumble.png" width="150" height="150"><br><br>';
						echo ( $Server->isRunning() ? '<span class="label label-success">'.$LANGUAGE['server_status_online'].'</span>' : '<span class="label label-danger">'.$LANGUAGE['server_status_offline'].'</span>' ) .'
						<br>';
						echo (   $Server->isRunning() ? count($Server->getUsers()).'/'.$Server->getConf('users').' '.$LANGUAGE['server_slots_in_use'] : '0' .'/ '.$Server->getConf('users').' '.$LANGUAGE['server_slots_in_use']).
						'
					</center>
			</div>';
			
		}
			
		echo '
			
			<div class="server new-server">
				<a href="#" onclick="$(\'#new-server\').dialog(\'open\'); return false;" style="margin: 0 auto; margin-top: 97px; padding: 10px 0 0 0; height: 47px; width: 50px; text-align: center;">
					<img src="../template/images/plus-white-big.png" />
				</a>
			</div>
		</div>
	</div>	


		<div id="new-server" class="dialogbox">
			<h3 style="text-align: center;">'.$LANGUAGE['newserver_title'].'</h3>
			<form action="./index.php?display=actions&create-server" method="post" class="center" id="newserver">

				<table style="width: 100%">
					<tr style="margin-top:10px;">
						<td width="40%">'.$LANGUAGE['newserver_name'].'</td>
						<td width="60%"><input type="text" name="serverName" class="form-control" placeholder="'.$LANGUAGE['newserver_name_hint'].'"></td>
					</tr>
					<tr style="padding-top:10px;">
						<td>'.$LANGUAGE['newserver_port'].'</td>
						<td><input type="text" name="serverPort" id="serverPort" maxlength="5" class="form-control" placeholder="'.$LANGUAGE['newserver_port_hint'].'"></td>
					</tr>
					<tr style="margin-top:10px;">
						<td>'. $LANGUAGE['newserver_slots'] .'</td>
						<td>
							<select class="form-control" name="serverSlots">';
								for ($i = 1; $i <= 100; $i++) 
								{
									echo '<option value="'. $i .'">'. $i .' Slots</option>';
								}echo '
							</select>
						</td>
					</tr>
				</table>
			
				<div style="width: 500px; text-align:center;"><a href="#" onclick="CheckAndSubmit();" class="custom-metro cm-green cm-auto">'. $LANGUAGE['newserver_btn_create'] .'</a> <a href="#" onclick="$(\'#new-server\').dialog(\'close\'); return false;"class="custom-metro cm-red cm-auto">'. $LANGUAGE['newserver_btn_cancel'] .'</a></div>
			
			</form>
		</div>
		

		<script type="text/javascript">
			newFlexibleDialog("new-server", 550);
			 $(\'input[name=serverPort]\').keydown(function(){
					$(this).val($(this).val().replace(/[^\d]/,\'\'));
				});
			 $(\'input[name=serverPort]\').keyup(function(){
					$(this).val($(this).val().replace(/[^\d]/,\'\'));
				});
				
			function CheckAndSubmit()
			{
				if(document.getElementById("serverPort").value != "")
				{
					newserver.submit();
				}
				else
				{
					document.getElementById("serverPort").style = "border-color: #9D1A1A;";
				};
			};
		</script>
';

?>
