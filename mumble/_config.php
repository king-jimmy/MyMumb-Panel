<?php

	if(isset($_POST['type']))
	{
		if($_POST['type'] == 'saveConfig')
		{
			if(isset($_POST['serverName']) && $_POST['serverName'] != "" && $_POST['serverName'] != $Server->getConf('registername'))
				$Server->setConf('registername', $_POST['serverName']);
				
			if(isset($_POST['password']) && $_POST['password'] != $Server->getConf('password'))
				$Server->setConf('password', $_POST['password']);

			if(isset($_POST['welcometext']) && $_POST['welcometext'] != $Server->getConf('welcometext'))
				$Server->setConf('welcometext', $_POST['welcometext']);
				
			if(isset($_POST['defaultchannel']) && $_POST['defaultchannel'] != $Server->getConf('defaultchannel'))
				$Server->setConf('defaultchannel', $_POST['defaultchannel']);
			
			if(isset($_POST['port']) && $_POST['port'] != $Server->getConf('port'))
				$Server->setConf('port', $_POST['port']);
				
			if(isset($_POST['serverSlots']) && $_POST['serverSlots'] != $Server->getConf('users'))
				$Server->setConf('users', $_POST['serverSlots']);
		}
	}	

	function getChildChannels($argChannel)
	{
		global $Server;
		$defaultChannel = $Server->getConf('defaultchannel');
		$defaultChannel = $Server->getChannelState(intval($defaultChannel));
		echo '<option '.($defaultChannel->id == $argChannel->id ? 'selected="selected"' : '').' value="'. $argChannel->id .'">'. $argChannel->name .'</option>';
		foreach ($Server->getChannels() as $Channel)
		{
			if($Channel->parent == $argChannel->id)
			{
				getChildChannels($Channel);
			}
		}		
	}
	
echo '
			<h1 style="text-align:center;">'. $LANGUAGE['config_title'] .'</h1>
			<div class="well">
				<center>
					<form action="" method="POST" id="save">
						<input type="hidden" name="type" value="saveConfig"/>
						<table style="text-align: center; border:0 !important; width:700px;" border="0">
						  <tbody>
							<tr>
								<td width="30%"><b>'. $LANGUAGE['config_servername'] .'</b></td>
							  <td><input type="text" name="serverName" class="form-control" placeholder="'. $LANGUAGE['config_servername_hint'] .'" value="'. $Server->getConf('registername') .'" ></td>
							</tr>
							<tr>
								<td><b>'. $LANGUAGE['config_password'] .'</b></td>
							  <td><input type="text" name="password" class="form-control" placeholder="'. $LANGUAGE['config_password_hint'] .'" value="'. $Server->getConf('password') .'"></td>
							</tr>
							<tr>
								<td><b>'. $LANGUAGE['config_welcomemessage'] .'</b></td>
							  <td><textarea name="welcometext" class="form-control" placeholder="'. $LANGUAGE['config_welcomemessage_hint'] .'">'. $Server->getConf('welcometext') .'</textarea></td>
							</tr>
							<tr>
								<td><b>'. $LANGUAGE['config_port'] .'</b></td>
							  <td><input type="text" name="port" class="form-control" placeholder="'. $LANGUAGE['config_port_hint'] .'" value="'. $Server->getConf('port') .'"></td>
							</tr>
							<tr>
								<td><b>'. $LANGUAGE['config_maxslots'] .'</b></td>
							  <td>
								<select class="form-control" name="serverSlots">';
									for ($i = 1; $i <= 100; $i++) 
									{
										echo '<option '.( $i == $Server->getConf('users') ? 'selected="selected"' : '' ).' value="'. $i .'">'. $i .' Slots</option>';
									}
									echo '
								</select>
							  </td>
							</tr>
							<tr>
								<td><b>'. $LANGUAGE['config_mainchan'] .'</b></td>
								<td>';
								if($Server->isRunning())
								{
									echo '<select class="form-control" id="select" name="defaultchannel">';
									$defaultChannel = $Server->getConf('defaultchannel');
									$defaultChannel = $Server->getChannelState(intval($defaultChannel));
									echo '<option value="0" '. ( $defaultChannel->id == 0 ? 'selected="selected"' : '' ) .'>'.$Server->getConf('registername').' (Root)</option>';
									foreach ($Server->getChannels() as $Channel)
									{
										if($Channel->parent == 0)
											getChildChannels($Channel);
									}		
									echo '</select>';
								}
								else
									echo $LANGUAGE['config_mustbeonline'];
									
								echo '
								</td>
							</tr>
						  </tbody>
						</table>
						<br>
						<div style="width: 500px;"><a href="#" onclick="save.submit();" class="custom-metro cm-green cm-auto">'. $LANGUAGE['config_btn_save'] .'</a> <a href="?server_id='. $_GET['server_id'] .'&display=overview" class="custom-metro cm-red cm-auto">'. $LANGUAGE['config_btn_cancel'] .'</a></div>
					</form>
				</center>
			</div>
			<div class="clear"></div>
		</div>
	';
	
	
	
	
	


	
	
	
	
?>