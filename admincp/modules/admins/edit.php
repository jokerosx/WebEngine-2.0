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

if(check($_POST['admin_submit'])) {
	try {
		
		if(!check($_POST['admin_username'], $_POST['admin_accesslevel'])) throw new Exception('Please complete all the required fields.');
		
		Admin::editAdmin($_POST['admin_username'], $_POST['admin_accesslevel']);
		
		redirect('admins/list');
		
	} catch(Exception $ex) {
		message('error', $ex->getMessage());
	}
}

$adminData = Admin::getAdminData($_GET['username']);
if(!is_array($adminData)) redirect('admins/list');

echo '<div class="row">';
	echo '<div class="col-sm-12 col-md-8 col-lg-6">';
		echo '<div class="card">';
			echo '<div class="header">Edit Admin</div>';
			echo '<div class="content">';
				
				echo '<form action="" method="post">';
				echo '<div class="form-group">';
					echo '<label for="input_1">Username</label>';
					echo '<input type="text" class="form-control" id="input_1" name="admin_username" value="'.$adminData['username'].'" required autofocus>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label for="input_2">Access Level</label>';
					echo '<input type="text" class="form-control" id="input_2" name="admin_accesslevel" value="'.$adminData['access_level'].'" required>';
				echo '</div>';
				echo '<button type="submit" class="btn btn-warning" name="admin_submit" value="ok">Save Changes</button> ';
				echo '<a href="'.admincp_base('admins/list').'" class="btn btn-danger">Cancel</a>';
			echo '</form>';
				
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</div>';