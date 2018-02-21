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

$adminList = Admin::getAdminList();

echo '<div class="row">';
	echo '<div class="col-sm-12 col-md-8 col-lg-6">';
		echo '<div class="card">';
			echo '<div class="header">Admin Access</div>';
			echo '<div class="content table-responsive table-full-width">';
				
				if(is_array($adminList)) {
					echo '<table class="table table-hover table-striped">';
					echo '<thead>';
						echo '<tr>';
							echo '<th>Username</th>';
							echo '<th>Access Level</th>';
							echo '<th class="text-right">Actions</th>';
						echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
					foreach($adminList as $adminData) {
						echo '<tr>';
							echo '<td>'.$adminData['username'].'</td>';
							echo '<td>'.$adminData['access_level'].'</td>';
							echo '<td class="td-actions text-right">';
								echo '<a href="'.admincp_base('admins/edit/username/'.$adminData['username']).'" rel="tooltip" title="" class="btn btn-warning btn-simple btn-xs" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
								echo '<a href="#" onclick="confirmationMessage(\''.admincp_base('admins/delete/username/'.$adminData['username']).'\', \'Are you sure?\', \'This action will immediately remove access to the admin control panel.\', \'Confirm\', \'Cancel\')" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="Delete"><i class="fa fa-times"></i></a>';
							echo '</td>';
						echo '</tr>';
					}
					echo '</tbody>';
					echo '</table>';
				} else {
					message('warning', 'There are no admins in the database.');
				}
				
			echo '</div>';
		echo '</div>';
		
		echo '<a href="'.admincp_base('admins/new').'" class="btn btn-primary">New Admin</a>';
		
	echo '</div>';
echo '</div>';