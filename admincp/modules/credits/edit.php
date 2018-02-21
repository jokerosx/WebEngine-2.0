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

if(check($_POST['edit_submit'])) {
	try {
		if(!check($_POST['edit_id'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['edit_title'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['edit_database'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['edit_table'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['edit_credits_column'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['edit_user_column'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['edit_user_column_id'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['edit_checkonline'])) throw new Exception("Please fill all the required fields.");
		if(!check($_POST['edit_display'])) throw new Exception("Please fill all the required fields.");
		
		$creditSystem->setConfigId($_POST['edit_id']);
		$creditSystem->setConfigTitle($_POST['edit_title']);
		if(check($_POST['edit_phrase'])) $creditSystem->setConfigPhrase($_POST['edit_phrase']);
		$creditSystem->setConfigDatabase($_POST['edit_database']);
		$creditSystem->setConfigTable($_POST['edit_table']);
		$creditSystem->setConfigCreditsColumn($_POST['edit_credits_column']);
		$creditSystem->setConfigUserColumn($_POST['edit_user_column']);
		$creditSystem->setConfigUserColumnId($_POST['edit_user_column_id']);
		$creditSystem->setConfigCheckOnline($_POST['edit_checkonline']);
		$creditSystem->setConfigDisplay($_POST['edit_display']);
		
		$creditSystem->editConfig();
		
		redirect('credits/config');
	} catch (Exception $ex) {
		message('error', $ex->getMessage());
	}
}

$creditSystem->setConfigId($_GET['id']);
$cofigsData = $creditSystem->showConfigs(true);

echo '<div class="row">';
	echo '<div class="col-sm-12 col-md-12 col-lg-4">';

		echo '<div class="card">';
			echo '<div class="header">Edit Credit Configuration</div>';
			echo '<div class="content">';
				
				echo '<form role="form" action="" method="post">';
				echo '<input type="hidden" name="edit_id" value="'.$cofigsData['config_id'].'"/>';
					echo '<div class="form-group">';
						echo '<label for="input_1">Title:</label>';
						echo '<input type="text" class="form-control" id="input_1" name="edit_title" value="'.$cofigsData['config_title'].'"/>';
					echo '</div>';
					
					echo '<div class="form-group">';
						echo '<label for="input_5">Language Phrase:</label>';
						echo '<input type="text" class="form-control" id="input_5" name="edit_phrase" value="'.$cofigsData['config_phrase'].'"/>';
					echo '</div>';

					echo '<label>Database:</label>';
					echo '<div class="radio">';
						echo '<label>';
							echo '<input type="radio" name="edit_database" id="databaseRadios1" value="MuOnline" '.($cofigsData['config_database'] == "MuOnline" ? 'checked' : null).'> MuOnline';
						echo '</label>';
					echo '</div>';
					echo '<div class="radio">';
						echo '<label>';
							echo '<input type="radio" name="edit_database" id="databaseRadios1" value="Me_MuOnline" '.($cofigsData['config_database'] == "Me_MuOnline" ? 'checked' : null).'> Me_MuOnline';
						echo '</label>';
					echo '</div><br />';

					echo '<div class="form-group">';
						echo '<label for="input_2">Table:</label>';
						echo '<input type="text" class="form-control" id="input_2" name="edit_table" value="'.$cofigsData['config_table'].'"/>';
					echo '</div>';

					echo '<div class="form-group">';
						echo '<label for="input_3">Credits Column:</label>';
						echo '<input type="text" class="form-control" id="input_3" name="edit_credits_column" value="'.$cofigsData['config_credits_col'].'"/>';
					echo '</div>';

					echo '<div class="form-group">';
						echo '<label for="input_4">User Column:</label>';
						echo '<input type="text" class="form-control" id="input_4" name="edit_user_column" value="'.$cofigsData['config_user_col'].'"/>';
					echo '</div>';

					echo '<label>User Identifier:</label>';
					echo '<div class="radio">';
						echo '<label>';
							echo '<input type="radio" name="edit_user_column_id" id="coRadios1" value="userid" '.($cofigsData['config_user_col_id'] == "userid" ? 'checked' : null).'> User ID';
						echo '</label>';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<label>';
							echo '<input type="radio" name="edit_user_column_id" id="coRadios1" value="username" '.($cofigsData['config_user_col_id'] == "username" ? 'checked' : null).'> Username';
						echo '</label>';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<label>';
							echo '<input type="radio" name="edit_user_column_id" id="coRadios1" value="email" '.($cofigsData['config_user_col_id'] == "email" ? 'checked' : null).'> Email';
						echo '</label>';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<label>';
							echo '<input type="radio" name="edit_user_column_id" id="coRadios1" value="character" '.($cofigsData['config_user_col_id'] == "character" ? 'checked' : null).'> Character Name';
						echo '</label>';
					echo '</div><br />';

					echo '<label>Check Online Status:</label>';
					echo '<div class="radio">';
						echo '<label>';
							echo '<input type="radio" name="edit_checkonline" id="coRadios1" value="1" '.($cofigsData['config_checkonline'] == 1 ? 'checked' : null).'> Yes';
						echo '</label>';
					echo '</div>';
					echo '<div class="radio">';
						echo '<label>';
							echo '<input type="radio" name="edit_checkonline" id="coRadios1" value="0" '.($cofigsData['config_checkonline'] == 0 ? 'checked' : null).'> No';
						echo '</label>';
					echo '</div><br />';

					echo '<label>Display in My Account:</label>';
					echo '<div class="radio">';
						echo '<label>';
							echo '<input type="radio" name="edit_display" id="coRadios1" value="1" '.($cofigsData['config_display'] == 1 ? 'checked' : null).'> Yes';
						echo '</label>';
					echo '</div>';
					echo '<div class="radio">';
						echo '<label>';
							echo '<input type="radio" name="edit_display" id="coRadios1" value="0" '.($cofigsData['config_display'] == 0 ? 'checked' : null).'> No';
						echo '</label>';
					echo '</div><br />';

					echo '<button type="submit" name="edit_submit" value="1" class="btn btn-warning">Save Changes</button> ';
					echo '<a href="'.admincp_base('credits/config').'" class="btn btn-large btn-danger">Cancel</a>';
				echo '</form>';

			echo '</div>';
		echo '</div>';
		
	echo '</div>';
echo '</div>';