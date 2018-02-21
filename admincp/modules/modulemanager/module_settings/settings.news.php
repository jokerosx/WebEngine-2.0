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

$configurationFile = $_GET['id'];

if(check($_POST['settings_submit'])) {
	try {
		
		// Expanded News
		if(!check($_POST['news_expanded'])) throw new Exception('Invalid setting value (news_expanded)');
		if(!Validator::UnsignedNumber($_POST['news_expanded'])) throw new Exception('Invalid setting value (news_expanded)');
		$setting['news_expanded'] = $_POST['news_expanded'];
		
		// News Display Limit
		if(!check($_POST['news_list_limit'])) throw new Exception('Invalid setting value (news_list_limit)');
		if(!Validator::UnsignedNumber($_POST['news_list_limit'])) throw new Exception('Invalid setting value (news_list_limit)');
		$setting['news_list_limit'] = $_POST['news_list_limit'];
		
		// Update Configurations
		if(!updateModuleConfig($configurationFile, $setting)) throw new Exception('There was an error updating the configuration file.');
		
		message('success', 'Settings successfully saved!');
	} catch(Exception $ex) {
		message('error', $ex->getMessage());
	}
}

$cfg = loadModuleConfig($configurationFile);
if(!is_array($cfg)) throw new Exception('Could not load configuration file.');

echo '<div class="row">';
	echo '<div class="col-sm-12">';
		echo '<div class="card">';
			echo '<div class="header">News Settings</div>';
			echo '<div class="content table-responsive">';
			
				echo '<form action="" method="post">';
					echo '<table class="table table-striped table-bordered table-hover" style="table-layout: fixed;">';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Expanded News</strong>';
								echo '<p class="setting-description"></p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="news_expanded" value="'.$cfg['news_expanded'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>News Display Limit</strong>';
								echo '<p class="setting-description"></p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="news_list_limit" value="'.$cfg['news_list_limit'].'">';
							echo '</td>';
						echo '</tr>';
						
						
					echo '</table>';
					echo '<br />';
					echo '<button type="submit" name="settings_submit" value="ok" class="btn btn-primary">Save Settings</button> ';
					echo '<a href="'.admincp_base('modulemanager/list').'" class="btn btn-danger">Cancel</a>';
				echo '</form>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</div>';