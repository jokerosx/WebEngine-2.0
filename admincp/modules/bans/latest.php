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
	
	$BanSystem = new AccountBan();
	$BanSystem->setLimit(50);
	$banList = $BanSystem->getBanList();
	
	echo '<div class="row">';
		echo '<div class="col-sm-12 col-md-12 col-lg-8">';
			
			// ban history
			echo '<div class="card">';
				echo '<div class="header">Latest Bans</div>';
				echo '<div class="content table-responsive table-full-width">';
					if(is_array($banList)) {
						echo '<table class="table table-hover table-striped">';
						echo '<thead>';
							echo '<tr>';
								echo '<th>Date</th>';
								echo '<th>Username</th>';
								echo '<th>By</th>';
								echo '<th>Type</th>';
								echo '<th>Duration</th>';
								echo '<th>Reason</th>';
								echo '<th>Status</th>';
								echo '<th class="text-right">Action</th>';
							echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
						foreach($banList as $banData) {
							$BanSystem->setUserid($banData['user_id']);
							$accountData = $BanSystem->getAccountData();
							if(!is_array($accountData)) continue;
							
							$banDuration = $BanSystem->formatBanDuration($banData['ban_duration']);
							$banStatus = $banData['ban_lifted'] == 1 ? '<span class="label label-default">Lifted</span>' : '<span class="label label-success">Active</span>';
							
							echo '<tr>';
								echo '<td>'.databaseTime($banData['ban_date']).'</td>';
								echo '<td>'.$accountData[_CLMN_USERNM_].'</td>';
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
						message('success', 'No bans found on the database.');
					}
					
				echo '</div>';
			echo '</div>';
			
		echo '</div>';
		
	echo '</div>';
	

} catch(Exception $ex) {
	message('error', $ex->getMessage());
}