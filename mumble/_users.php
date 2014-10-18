<?php
if($Server->isRunning())
{
echo '
			<h1 style="text-align:center;">Liste des Utilisateurs</h1>
			<div class="well">';
			if(isset($_POST['type']))
				{
					if($_POST['type'] == 'new-user')
					{
						try 
						{
							$userInfos = array();
							if(isset($_POST['username']) && $_POST['username'] != "")
								$userInfos[0] = $_POST['username'];
								
							if(isset($_POST['password']) && $_POST['password'] != "")
								$userInfos[4] = $_POST['password'];
								
								
							if(isset($_POST['username']) && $_POST['username'] != "" or isset($_POST['password']) && $_POST['password'] != "" )	
								$Server->registerUser($userInfos);
							else
								$AlertMessage = '';
						}
						catch (Exception $e) 
						{
							echo '<div class="alert alert-danger" style="text-align:center;">'. $LANGUAGE['users_alert_alreadyexist'] .'</div>';
						}
					}
					
					if($_POST['type'] == 'edit-user')
					{
						try 
						{
							$userInfos = array();
							if(isset($_POST['username']) && $_POST['username'] != "")
								$userInfos[0] = $_POST['username'];
								
							if(isset($_POST['password']) && $_POST['password'] != "")
								$userInfos[4] = $_POST['password'];
								
							$Server->updateRegistration(intval($_POST['userid']), $userInfos);
							
						}
						catch (Exception $e) 
						{
							echo '<div class="alert alert-danger" style="text-align:center;">'. $LANGUAGE['users_alert_alreadyexist'] .'</div>';
						}
					}
				}
				if(isset($_GET['delete']))
				{
					try 
					{
						$Server->unregisterUser(intval($_GET['delete']));
					} 
					catch (Exception $e) 
					{
						echo '<div class="alert alert-danger" style="text-align:center;">'. ( $_GET['delete'] == 0 ? $LANGUAGE['users_alert_cantdelete'] : $LANGUAGE['users_alert_deletenotfound']).'</div>';
					}
				}
				try 
				{
			echo '
				<center>
					<form action="" method="POST" id="userform">
						<input type="hidden" name="type" value="'.( isset($_GET['edit']) ? 'edit-user' : 'new-user') . '"/>
						'.( isset($_GET['edit']) ? '<input type="hidden" name="userid" value="'. $_GET['edit'] .'"/>' : '').'
						<table style="text-align: center; border:0 !important;" border="0" cellpadding="2" cellspacing="2">
						  <tbody>
							<tr>
							  <td><input type="text" class="ttt form-control" name="username" placeholder="'. $LANGUAGE['users_input_username_help'] .'" value="' . ( isset($_GET['edit']) ? $Server->getRegistration(intval($_GET['edit']))[0] : '') . '"></td>
							  <td><input type="text" class="form-control" name="password" placeholder="'. $LANGUAGE['users_input_password_help'] .'"></td>
								<td><a href="#" onclick="userform.submit();" class="custom-metro cm-blue2">' . ( isset($_GET['edit']) ? $LANGUAGE['users_btn_edituser'] : $LANGUAGE['users_btn_adduser']) . '</a></td>
							</tr>
						  </tbody>
						</table>
					</form>
				</center>';
				}
				catch (Exception $e) 
				{
					echo '<div class="alert alert-danger" style="text-align:center;">'. $LANGUAGE['users_alert_usernotfound'] .'</div>';
					echo '
						<center>
							<form action="" method="POST" id="userform">
								<input type="hidden" name="type" value="new-user"/>
								<table style="text-align: center; border:0 !important;" border="0" cellpadding="2" cellspacing="2">
								  <tbody>
									<tr>
									  <td><input type="text" class="ttt form-control" name="username" placeholder="'. $LANGUAGE['users_input_username_help'] .'" value=""></td>
									  <td><input type="text" class="form-control" name="password" placeholder="'. $LANGUAGE['users_input_password_help'] .'"></td>
										<td><a href="#" onclick="userform.submit();" class="custom-metro cm-blue2">'.$LANGUAGE['users_btn_adduser'].'</a></td>
									</tr>
								  </tbody>
								</table>
							</form>
						</center>';
				}
			echo '
					<table>
						<tr>
							<th style="text-align: center; width: 40px;"></th>
							<th width="300px">'. $LANGUAGE['users_header_name'] .'</th>
							<th width="300px">'. $LANGUAGE['users_header_lastconnect'] .'</th>
							<th width="250px" style="text-align: center;">'. $LANGUAGE['users_header_action'] .'</th>
						</tr>';
						
						foreach($Server->getRegisteredUsers('') as $userId=>$userName)
						{
							if($userName != "SuperUser")
							{
								echo '
								<tr>
									<td style="text-align: center; width: 40px;"><img src="'. $MyConfig['http_adress'] .'/template/images/user-big.png" width="25" height="25"/></td>
									<td>'. $userName .'</td>
									<td>'. ( $Server->getRegistration(intval($userId))[5] == '' ? $LANGUAGE['user_neverconnected'] : $Server->getRegistration(intval($userId))[5]) .'</td>
									<td><a href="'. $MyConfig['http_adress'] .'/mumble/server/'. $_GET['server_id'] .'/users/'. $userId .'" class="custom-metro cm-small cm-blue2">'. $LANGUAGE['users_btn_edit'] .'</a> <a href="'. $MyConfig['http_adress'] .'/mumble/server/'. $_GET['server_id'] .'/users/delete-'. $userId .'" class="custom-metro cm-small cm-red">'. $LANGUAGE['users_btn_delete'] .'</a></td>
								</tr>';
							}
						}
						echo '
				</table>
			</div>
			<div class="clear"></div>';
		
}
else
{
	echo '<center><br><br><span style="font-size:22px;">'. $LANGUAGE['server_must_be_on'] .'</span></center>';
}
?>
