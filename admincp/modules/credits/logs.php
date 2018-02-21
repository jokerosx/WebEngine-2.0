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
	
	$creditSystem = new CreditSystem();
	$creditSystem->setLimit(0);
	if(check($_GET['username'])) $creditSystem->setCustomIdentifier($_GET['username']);
	if(check($_GET['userid'])) $creditSystem->setCustomIdentifier($_GET['userid']);
	if(check($_GET['email'])) $creditSystem->setCustomIdentifier($_GET['email']);
	$logs = $creditSystem->getLogs();
	
	echo '<div class="row">';
		echo '<div class="col-sm-12 col-md-12 col-lg-12">';
			
			echo '<div class="card">';
				echo '<div class="header">Credit System Logs</div>';
				echo '<div class="content table-responsive table-full-width">';
					if(is_array($logs)) {
						echo '<table class="table table-hover table-striped">';
						echo '<thead>';
							echo '<tr>';
								echo '<th>Config</th>';
								echo '<th>Identifier Value</th>';
								echo '<th>Credits</th>';
								echo '<th>Transaction</th>';
								echo '<th>Date</th>';
								echo '<th>Module</th>';
								echo '<th>Ip</th>';
								echo '<th>AdminCP</th>';
							echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
						foreach($logs as $data) {
							$in_admincp = $data['log_inadmincp'] == 1 ? '<span class="label label-success">yes</span>' : '<span class="label label-default">No</span>';
							$transaction = $data['log_transaction'] == "add" ? '<span class="label label-success">Add</span>' : '<span class="label label-danger">Subtract</span>';

							echo '<tr>';
								echo '<td>'.$data['log_config'].'</td>';
								echo '<td>'.$data['log_identifier'].'</td>';
								echo '<td>'.$data['log_credits'].'</td>';
								echo '<td>'.$transaction.'</td>';
								echo '<td>'.databaseTime($data['log_date']).'</td>';
								echo '<td>'.$data['log_module'].'</td>';
								echo '<td>'.$data['log_ip'].'</td>';
								echo '<td>'.$in_admincp.'</td>';
							echo '</tr>';
						}
						echo '</tbody>';
						echo '</table>';
					} else {
						message('success', 'No logs found on the database.');
					}
					
				echo '</div>';
			echo '</div>';
			
		echo '</div>';
		
	echo '</div>';
	

} catch(Exception $ex) {
	message('error', $ex->getMessage());
}