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

if(check($_POST['ban_submit'])) {
	try {
		
		if(!check($_POST['ban_username'], $_POST['ban_duration'])) throw new Exception('Please complete all the required fields.');
		
		$BanSystem = new AccountBan();
		$BanSystem->setUsername($_POST['ban_username']);
		$BanSystem->setBanBy($_SESSION['username']);
		
		if($_POST['ban_duration'] == 0) {
			$BanSystem->setBanType('permanent');
		} else {
			$BanSystem->setBanType('temporal');
			$BanSystem->setBanDuration($_POST['ban_duration']);
		}
		
		if(check($_POST['ban_reason'])) {
			$BanSystem->setBanReason($_POST['ban_reason']);
		}
		
		$BanSystem->ban();
		
		$accountData = $BanSystem->getAccountData();
		if(!is_array($accountData)) throw new Exception('Could not load account information.');
		
		redirect('account/profile/username/' . $accountData[_CLMN_USERNM_]);
		
	} catch(Exception $ex) {
		message('error', $ex->getMessage());
	}
}

// ban system object
$BanSystem = new AccountBan();
$commonBanDurations = $BanSystem->getCommonBanDurations();

// ban username
$banUsername = check($_POST['ban_username']) ? $_POST['ban_username'] : '';
if(check($_GET['username'])) {
	$banUsername = $_GET['username'];
}

// ban duration
$banDuration = check($_POST['ban_duration']) ? $_POST['ban_duration'] : 0;

// ban reason
$banReason = check($_POST['ban_reason']) ? $_POST['ban_reason'] : '';

echo '<div class="row">';
	echo '<div class="col-sm-12 col-md-8 col-lg-6">';
		echo '<div class="card">';
			echo '<div class="header">Ban Account</div>';
			echo '<div class="content">';
				
			echo '<form action="" method="post">';
				echo '<div class="form-group">';
					echo '<label for="input_1">Username</label>';
					echo '<input type="text" class="form-control" id="input_1" name="ban_username" value="'.$banUsername.'" required autofocus>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label for="input_2">Duration</label>';
					echo '<select class="form-control" id="input_2" name="ban_duration">';
						if(is_array($commonBanDurations)) {
							foreach($commonBanDurations as $banDurationValue => $banDuration) {
								if($banDurationValue == $banDuration) {
									echo '<option value="'.$banDurationValue.'" selected>'.$banDuration.'</option>';
								} else {
									echo '<option value="'.$banDurationValue.'">'.$banDuration.'</option>';
								}
							}
						}
					echo '</select>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label for="input_3">Reason</label>';
					echo '<textarea class="form-control" id="input_3" name="ban_reason" style="height:100px;" maxlength="100">'.$banReason.'</textarea>';
				echo '</div>';
				echo '<button type="submit" class="btn btn-info" name="ban_submit" value="ok">Ban</button>';
			echo '</form>';
				
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</div>';