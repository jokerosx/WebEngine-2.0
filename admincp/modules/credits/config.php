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

$creditSystem = new CreditSystem();

if(check($_POST['new_submit'])) {
	try {
		if(!check($_POST['new_title'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['new_database'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['new_table'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['new_credits_column'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['new_user_column'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['new_user_column_id'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['new_checkonline'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['new_display'])) throw new Exception("Please fill all the required fields.");
		
		$creditSystem->setConfigTitle($_POST['new_title']);
		if(check($_POST['new_phrase'])) $creditSystem->setConfigPhrase($_POST['new_phrase']);
		$creditSystem->setConfigDatabase($_POST['new_database']);
		$creditSystem->setConfigTable($_POST['new_table']);
		$creditSystem->setConfigCreditsColumn($_POST['new_credits_column']);
		$creditSystem->setConfigUserColumn($_POST['new_user_column']);
		$creditSystem->setConfigUserColumnId($_POST['new_user_column_id']);
		$creditSystem->setConfigCheckOnline($_POST['new_checkonline']);
		$creditSystem->setConfigDisplay($_POST['new_display']);
		$creditSystem->saveConfig();
		
		redirect('credits/config');
	} catch (Exception $ex) {
		message('error', $ex->getMessage());
	}
}

echo '<div class="row">';
	echo '<div class="col-sm-12 col-md-12 col-lg-4">';
	
		echo '<div class="card">';
			echo '<div class="header">New Credit Configuration</div>';
			echo '<div class="content">';

				echo '<form role="form" action="" method="post">';
					echo '<div class="form-group">';
						echo '<label for="input_1">Title (admincp use only):</label>';
						echo '<input type="text" class="form-control" id="input_1" name="new_title"/>';
					echo '</div>';
					
					echo '<div class="form-group">';
						echo '<label for="input_5">Language Phrase (currency name):</label>';
						echo '<input type="text" class="form-control" id="input_5" name="new_phrase" placeholder="general_currency_name"/>';
					echo '</div>';

					echo '<label>Database:</label>';
					echo '<div class="radio">';
						echo '<label>';
							echo '<input type="radio" name="new_database" id="databaseRadios1" value="MuOnline" checked> ' . config('SQL_DB_NAME');
						echo '</label>';
					echo '</div>';
					
					if(config('SQL_USE_2_DB')) {
						echo '<div class="radio">';
							echo '<label>';
								echo '<input type="radio" name="new_database" id="databaseRadios1" value="Me_MuOnline"> ' . config('SQL_DB_2_NAME');
							echo '</label>';
						echo '</div><br />';
					}

					echo '<div class="form-group">';
						echo '<label for="input_2">Table:</label>';
						echo '<input type="text" class="form-control" id="input_2" name="new_table"/>';
					echo '</div>';

					echo '<div class="form-group">';
						echo '<label for="input_3">Credits Column:</label>';
						echo '<input type="text" class="form-control" id="input_3" name="new_credits_column"/>';
					echo '</div>';

					echo '<div class="form-group">';
						echo '<label for="input_4">User Column:</label>';
						echo '<input type="text" class="form-control" id="input_4" name="new_user_column"/>';
					echo '</div>';
					
					echo '<label>User Identifier:</label>';
					echo '<div class="radio">';
						echo '<label>';
							echo '<input type="radio" name="new_user_column_id" id="coRadios1" value="userid" checked> User ID';
						echo '</label>';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<label>';
							echo '<input type="radio" name="new_user_column_id" id="coRadios1" value="username"> Username';
						echo '</label>';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<label>';
							echo '<input type="radio" name="new_user_column_id" id="coRadios1" value="email"> Email';
						echo '</label>';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<label>';
							echo '<input type="radio" name="new_user_column_id" id="coRadios1" value="character"> Character Name';
						echo '</label>';
					echo '</div><br />';

					echo '<label>Check Online Status:</label>';
					echo '<div class="radio">';
						echo '<label>';
							echo '<input type="radio" name="new_checkonline" id="coRadios1" value="1" checked> Yes';
						echo '</label>';
					echo '</div>';
					echo '<div class="radio">';
						echo '<label>';
							echo '<input type="radio" name="new_checkonline" id="coRadios1" value="0"> No';
						echo '</label>';
					echo '</div><br />';

					echo '<label>Display in My Account:</label>';
					echo '<div class="radio">';
						echo '<label>';
							echo '<input type="radio" name="new_display" id="coRadios1" value="1" checked> Yes';
						echo '</label>';
					echo '</div>';
					echo '<div class="radio">';
						echo '<label>';
							echo '<input type="radio" name="new_display" id="coRadios1" value="0"> No';
						echo '</label>';
					echo '</div><br />';	

					echo '<button type="submit" name="new_submit" value="1" class="btn btn-primary">Save Configuration</button>';
				echo '</form>';

			echo '</div>';
		echo '</div>';
	
	echo '</div>';
	echo '<div class="col-sm-12 col-md-12 col-lg-8">';
		
		echo '<div class="card">';
			echo '<div class="header">Configurations</div>';
			echo '<div class="content">';
				$cofigsList = $creditSystem->showConfigs();
				if(is_array($cofigsList)) {
					echo '<table class="table table-condensed table-hover">';
					echo '<thead>';
						echo '<tr>';
							echo '<th>Title</th>';
							echo '<th>Phrase</th>';
							echo '<th>Database</th>';
							echo '<th>Table</th>';
							echo '<th>Credits Column</th>';
							echo '<th>User Column</th>';
							echo '<th>User Column Identifier</th>';
							echo '<th>Online Check</th>';
							echo '<th>Display</th>';
							echo '<th class="text-right">Actions</th>';
						echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
					foreach($cofigsList as $data) {
						
						$checkOnline = $data['config_checkonline'] ? '<span class="label label-success">Yes</span>' : '<span class="label label-default">No</span>';
						$configdisplay = $data['config_display'] ? '<span class="label label-success">Yes</span>' : '<span class="label label-default">No</span>';
						$languagePhrase = check($data['config_phrase']) ? '<span rel="tooltip" title="" data-original-title="'.lang($data['config_phrase']).'">'.$data['config_phrase'].'</span>' : '';
						
						echo '<tr>';
							echo '<td>'.$data['config_title'].'</td>';
							echo '<td>'.$languagePhrase.'</td>';
							echo '<td>'.$data['config_database'].'</td>';
							echo '<td>'.$data['config_table'].'</td>';
							echo '<td>'.$data['config_credits_col'].'</td>';
							echo '<td>'.$data['config_user_col'].'</td>';
							echo '<td>'.$data['config_user_col_id'].'</td>';
							echo '<td>'.$checkOnline.'</td>';
							echo '<td>'.$configdisplay.'</td>';
							echo '<td class="td-actions text-right">';	
								echo '<a href="'.admincp_base('credits/edit/id/'.$data['config_id']).'" rel="tooltip" title="" class="btn btn-warning btn-simple btn-xs" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
								echo '<a href="#" onclick="confirmationMessage(\''.admincp_base('credits/delete/id/'.$data['config_id']).'\', \'Are you sure?\', \'This action will permanently delete this credit configuration. Modules using this credit configuration will need to be configured again.\', \'Confirm\', \'Cancel\')" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="Delete"><i class="fa fa-times"></i></a>';
							echo '</td>';
						echo '</tr>';
					}
					echo '
					</tbody>
					</table>';
				} else {
					message('warning', 'You have not created any configuration.');
				}
			echo '</div>';
		echo '</div>';
		
	echo '</div>';
echo '</div>';