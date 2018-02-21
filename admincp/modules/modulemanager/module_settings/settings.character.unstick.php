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
		
		// Required Level
		if(!check($_POST['required_level'])) throw new Exception('Invalid setting value (required_level)');
		if(!Validator::UnsignedNumber($_POST['required_level'])) throw new Exception('Invalid setting value (required_level)');
		$setting['required_level'] = $_POST['required_level'];
		
		// Required Zen
		if(!check($_POST['required_zen'])) throw new Exception('Invalid setting value (required_zen)');
		if(!Validator::UnsignedNumber($_POST['required_zen'])) throw new Exception('Invalid setting value (required_zen)');
		$setting['required_zen'] = $_POST['required_zen'];
		
		// Map
		if(!check($_POST['map'])) throw new Exception('Invalid setting value (map)');
		if(!Validator::UnsignedNumber($_POST['map'])) throw new Exception('Invalid setting value (map)');
		$setting['map'] = $_POST['map'];
		
		// Coord X
		if(!check($_POST['coord_x'])) throw new Exception('Invalid setting value (coord_x)');
		if(!Validator::UnsignedNumber($_POST['coord_x'])) throw new Exception('Invalid setting value (coord_x)');
		$setting['coord_x'] = $_POST['coord_x'];
		
		// Coord Y
		if(!check($_POST['coord_y'])) throw new Exception('Invalid setting value (coord_y)');
		if(!Validator::UnsignedNumber($_POST['coord_y'])) throw new Exception('Invalid setting value (coord_y)');
		$setting['coord_y'] = $_POST['coord_y'];
		
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
			echo '<div class="header">Character Unstick Settings</div>';
			echo '<div class="content table-responsive">';
			
				echo '<form action="" method="post">';
					echo '<table class="table table-striped table-bordered table-hover" style="table-layout: fixed;">';
					
						echo '<tr>';
							echo '<td>';
								echo '<strong>Required Level</strong>';
								echo '<p class="setting-description">Level required to unstick the character.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="required_level" value="'.$cfg['required_level'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Required Zen</strong>';
								echo '<p class="setting-description">Amount of zen needed to unstick the character.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="required_zen" value="'.$cfg['required_zen'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Map</strong>';
								echo '<p class="setting-description">Map number where the character will be teleported to.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="map" value="'.$cfg['map'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Coord X</strong>';
								echo '<p class="setting-description">X coordinate of the selected map.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="coord_x" value="'.$cfg['coord_x'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Coord Y</strong>';
								echo '<p class="setting-description">Y coordinate of the selected map.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="coord_y" value="'.$cfg['coord_y'].'">';
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