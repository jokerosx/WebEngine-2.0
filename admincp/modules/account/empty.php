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

$Account = new Account();
$accountList = $Account->getFullAccountList();

echo '<div class="row">';
	echo '<div class="col-sm-12 col-md-10 col-lg-8">';
		echo '<div class="card">';
			echo '<div class="header">Empty Accounts</div>';
			echo '<div class="content table-responsive table-full-width">';
				
				if(is_array($accountList)) {
					echo '<table class="table table-hover table-striped">';
					echo '<thead>';
						echo '<tr>';
							echo '<th class="text-center">#</th>';
							echo '<th>Username</th>';
							echo '<th>Email Address</th>';
							echo '<th class="text-right">Actions</th>';
						echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
					foreach($accountList as $accountData) {
						$Player = new Player();
						$Player->setUsername($accountData[_CLMN_USERNM_]);
						$accountCharacters = $Player->getAccountPlayerList();
						if(is_array($accountCharacters)) continue;
						
						echo '<tr>';
							echo '<td class="text-center">'.$accountData[_CLMN_MEMBID_].'</td>';
							echo '<td>'.$accountData[_CLMN_USERNM_].'</td>';
							echo '<td>'.$accountData[_CLMN_EMAIL_].'</td>';
							echo '<td class="td-actions text-right">';
								echo '<a href="'.admincp_base('account/profile/username/'.$accountData[_CLMN_USERNM_]).'" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Profile"><i class="fa fa-user"></i></a>';
							echo '</td>';
						echo '</tr>';
					}
					echo '</tbody>';
					echo '</table>';
				} else {
					message('warning', 'There are no accounts in the database.');
				}
				
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</div>';