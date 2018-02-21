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
	
	if(!check($_GET['username'])) throw new Exception('The provided username is not valid.');
	
	$Account = new Account();
	$Account->setUsername($_GET['username']);
	$accountData = $Account->getAccountData();
	if(!is_array($accountData)) throw new Exception('Account data could not be loaded.');
	
	echo '<h1 class="text-info">'.$accountData[_CLMN_USERNM_].'</h1>';
	echo '<hr>';
	echo '<div class="row">';
		echo '<div class="col-sm-12 col-md-8 col-lg-6">';
			
			// change email process
			if(check($_POST['account_submit'])) {
				try {
					
					if(!check($_POST['account_email'], $_POST['account_username'], $_POST['account_userid'])) throw new Exception('Please complete all fields.');
					
					$AccountEmail = new AccountEmail();
					$AccountEmail->setUserid($_POST['account_userid']);
					$AccountEmail->setNewEmail($_POST['account_email']);
					$AccountEmail->manualEmailChange();
					
					redirect('account/profile/username/'.$_POST['account_username']);
					
				} catch(Exception $ex) {
					message('error', $ex->getMessage());
				}
			}
			
			echo '<div class="card">';
				echo '<div class="header">Change Email Address</div>';
				echo '<div class="content">';
					
					echo '<form action="'.admincp_base('account/email/username/'.$accountData[_CLMN_USERNM_]).'" method="post">';
						echo '<input type="hidden" name="account_username" value="'.$accountData[_CLMN_USERNM_].'">';
						echo '<input type="hidden" name="account_userid" value="'.$accountData[_CLMN_MEMBID_].'">';
						echo '<div class="form-group">';
							echo '<label for="input_1">New Email Address</label>';
							echo '<input type="email" class="form-control" id="input_1" name="account_email" required autofocus>';
						echo '</div>';
						echo '<button type="submit" class="btn btn-info" name="account_submit" value="ok">Change</button> ';
						echo '<a href="'.admincp_base('account/profile/username/'.$accountData[_CLMN_USERNM_]).'" class="btn btn-danger">Cancel</a>';
					echo '</form>';
					
				echo '</div>';
			echo '</div>';
		
		echo '</div>';
	echo '</div>';
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}