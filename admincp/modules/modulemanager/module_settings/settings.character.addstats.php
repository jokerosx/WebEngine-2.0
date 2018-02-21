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
		
		// Required level
		if(!check($_POST['required_level'])) throw new Exception('Invalid setting value (required_level)');
		if(!Validator::UnsignedNumber($_POST['required_level'])) throw new Exception('Invalid setting value (required_level)');
		$setting['required_level'] = $_POST['required_level'];
		
		// Required Zen
		if(!check($_POST['required_zen'])) throw new Exception('Invalid setting value (required_zen)');
		if(!Validator::UnsignedNumber($_POST['required_zen'])) throw new Exception('Invalid setting value (required_zen)');
		$setting['required_zen'] = $_POST['required_zen'];
		
		// Max Stats
		if(!check($_POST['max_stats'])) throw new Exception('Invalid setting value (max_stats)');
		if(!Validator::UnsignedNumber($_POST['max_stats'])) throw new Exception('Invalid setting value (max_stats)');
		$setting['max_stats'] = $_POST['max_stats'];
		
		// Minimum Points to Add
		if(!check($_POST['min_points'])) throw new Exception('Invalid setting value (min_points)');
		if(!Validator::UnsignedNumber($_POST['min_points'])) throw new Exception('Invalid setting value (min_points)');
		$setting['min_points'] = $_POST['min_points'];
		
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
			echo '<div class="header">Character Add Stats Settings</div>';
			echo '<div class="content table-responsive">';
			
				echo '<form action="" method="post">';
					echo '<table class="table table-striped table-bordered table-hover" style="table-layout: fixed;">';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Required Level</strong>';
								echo '<p class="setting-description">Level required to add stats.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="required_level" value="'.$cfg['required_level'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Required Zen</strong>';
								echo '<p class="setting-description">Amount of zen needed to add stats.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="required_zen" value="'.$cfg['required_zen'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Max Stats</strong>';
								echo '<p class="setting-description">Maximum amount of points for each stat.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="max_stats" value="'.$cfg['max_stats'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Minimum Points to Add</strong>';
								echo '<p class="setting-description">Minimum amount of points to use the add stats module.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="min_points" value="'.$cfg['min_points'].'">';
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