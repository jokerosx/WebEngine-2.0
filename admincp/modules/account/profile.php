<?php
/**
 * WebEngine CMS
 * https://webenginecms.org/
 * 
 * @version 2.0.0
 * @author Lautaro Angelico <https://lautaroangelico.com/>
 * @copyright (c) 2013-2018 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * https://opensource.org/licenses/MIT
 */

try {
	
	if(!check($_GET['username'])) throw new Exception('Username not provided.');
	
	$Account = new Account();
	$Account->setUsername($_GET['username']);
	$accountData = $Account->getAccountData();
	if(!is_array($accountData)) throw new Exception('Account data could not be loaded.');
	
	$Player = new Player();
	$Player->setUsername($accountData[_CLMN_USERNM_]);
	$characterList = $Player->getAccountPlayerList();
	
	$BanSystem = new AccountBan();
	$BanSystem->setUserid($accountData[_CLMN_MEMBID_]);
	$banHistory = $BanSystem->getAccountBanList();
	
	echo '<h1 class="text-info">'.$accountData[_CLMN_USERNM_].'</h1>';
	echo '<hr>';
	echo '<div class="row">';
		echo '<div class="col-sm-12 col-md-12 col-lg-6">';
			
			// general info
			echo '<div class="card">';
				echo '<div class="header">General Information</div>';
				echo '<div class="content table-responsive table-full-width">';
					echo '<table class="table table-hover table-striped">';
					echo '<thead>';
						echo '<tr>';
							echo '<th>Data</th>';
							echo '<th>Value</th>';
							echo '<th class="text-right">Action</th>';
						echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
						echo '<tr>';
							echo '<td>Id</td>';
							echo '<td>'.$accountData[_CLMN_MEMBID_].'</td>';
							echo '<td class="text-right"></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Username</td>';
							echo '<td>'.$accountData[_CLMN_USERNM_].'</td>';
							echo '<td class="text-right"></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Password</td>';
							echo '<td>******</td>';
							echo '<td class="text-right"><a href="'.admincp_base('account/password/username/'.$accountData[_CLMN_USERNM_]).'" class="btn btn-xs btn-default">Change</a></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Email Address</td>';
							echo '<td>'.$accountData[_CLMN_EMAIL_].'</td>';
							echo '<td class="text-right"><a href="'.admincp_base('account/email/username/'.$accountData[_CLMN_USERNM_]).'" class="btn btn-xs btn-default">Change</a></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Serial Number</td>';
							echo '<td>'.$accountData[_CLMN_SNONUMBER_].'</td>';
							echo '<td class="text-right"></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Banned</td>';
							echo '<td>'.($accountData[_CLMN_BLOCCODE_] == 0 ? '<span class="label label-default">No</span>' : '<span class="label label-danger">Yes</span>').'</td>';
							echo '<td class="text-right">'.($accountData[_CLMN_BLOCCODE_] == 0 ? '<a href="'.admincp_base('bans/new/username/'.$accountData[_CLMN_USERNM_]).'" class="btn btn-xs btn-danger">Ban</a>' : null).'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Status</td>';
							echo '<td>'.($Account->isOnline() ? '<span class="label label-success">Online</span>' : '<span class="label label-default">Offline</span>').'</td>';
							echo '<td></td>';
						echo '</tr>';
						
						// credit system
						try {
							$creditSystem = new CreditSystem();
							$creditCofigList = $creditSystem->showConfigs();
							if(is_array($creditCofigList)) {
								foreach($creditCofigList as $accountCredits) {
									
									$creditSystem->setConfigId($accountCredits['config_id']);
									switch($accountCredits['config_user_col_id']) {
										case 'userid':
											$creditSystem->setIdentifier($accountData[_CLMN_MEMBID_]);
											$identifier = $accountData[_CLMN_MEMBID_];
											break;
										case 'username':
											$creditSystem->setIdentifier($accountData[_CLMN_USERNM_]);
											$identifier = $accountData[_CLMN_USERNM_];
											break;
										case 'email':
											$creditSystem->setIdentifier($accountData[_CLMN_EMAIL_]);
											$identifier = $accountData[_CLMN_EMAIL_];
											break;
										default:
											continue;
									}
									
									$configCredits = $creditSystem->getCredits();
									
									echo '<tr>';
										echo '<td>'.lang($accountCredits['config_phrase']).'</td>';
										echo '<td>'.number_format($configCredits).'</td>';
										echo '<td class="text-right">';
											echo '<a href="'.admincp_base('credits/logs/'.$accountCredits['config_user_col_id'].'/'.$identifier).'" class="btn btn-xs btn-default">Logs</a>';
										echo '</td>';
									echo '</tr>';
								}
							}
						} catch(Exception $ex) {}
						
					echo '</tbody>';
					echo '</table>';
				echo '</div>';
			echo '</div>';
			
		echo '</div>';
		
		echo '<div class="col-sm-12 col-md-12 col-lg-6">';
			
			// characters
			echo '<div class="card">';
				echo '<div class="header">Characters</div>';
				echo '<div class="content table-responsive table-full-width">';
					if(is_array($characterList)) {
						echo '<table class="table table-hover table-striped">';
						echo '<thead>';
							echo '<tr>';
								echo '<th>Name</th>';
								echo '<th class="text-right">Action</th>';
							echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
						foreach($characterList as $character) {
							if(!check($character)) continue;
							echo '<tr>';
								echo '<td>'.$character.'</td>';
								echo '<td class="td-actions text-right">';
									echo '<a href="'.admincp_base('character/profile/name/'.$character).'" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Profile"><i class="fa fa-user"></i></a>';
								echo '</td>';
							echo '</tr>';
						}
						echo '</tbody>';
						echo '</table>';
					} else {
						message('warning', 'No characters found in account.');
					}
				echo '</div>';
			echo '</div>';
			
		echo '</div>';
	echo '</div>';
	
	echo '<div class="row">';
		echo '<div class="col-sm-12 col-md-12 col-lg-6">';
			
			// ban history
			echo '<div class="card">';
				echo '<div class="header">Ban History</div>';
				echo '<div class="content table-responsive table-full-width">';
					if(is_array($banHistory)) {
						echo '<table class="table table-hover table-striped">';
						echo '<thead>';
							echo '<tr>';
								echo '<th>Date</th>';
								echo '<th>By</th>';
								echo '<th>Type</th>';
								echo '<th>Duration</th>';
								echo '<th>Reason</th>';
								echo '<th>Status</th>';
								echo '<th class="text-right">Action</th>';
							echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
						foreach($banHistory as $banData) {
							$banDuration = $BanSystem->formatBanDuration($banData['ban_duration']);
							$banStatus = $banData['ban_lifted'] == 1 ? '<span class="label label-default">Lifted</span>' : '<span class="label label-success">Active</span>';
							
							echo '<tr>';
								echo '<td>'.databaseTime($banData['ban_date']).'</td>';
								echo '<td>'.$banData['ban_by'].'</td>';
								echo '<td>'.$banData['ban_type'].'</td>';
								echo '<td>'.$banDuration.'</td>';
								echo '<td><button type="button" class="btn btn-xs btn-default" data-container="body" data-toggle="popover" data-placement="top" data-trigger="focus" data-content="'.$banData['ban_reason'].'">Reason</button></td>';
								echo '<td>'.$banStatus.'</td>';
								echo '<td class="text-right">'.($banData['ban_lifted'] == 0 ? '<a href="'.admincp_base('bans/lift/id/'.$banData['ban_id'].'/username/'.$accountData[_CLMN_USERNM_]).'" class="btn btn-xs btn-success">Lift Ban</a>' : null).'</td>';
							echo '</tr>';
						}
						echo '</tbody>';
						echo '</table>';
					} else {
						message('success', 'No bans found for account.');
					}
					
				echo '</div>';
			echo '</div>';
			
		echo '</div>';
		
	echo '</div>';
	
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}