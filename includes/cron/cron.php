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
	
	// Access
	define('access', 'cron');
	
	// Load WebEngine
	include_once(str_replace('\\','/',dirname(__DIR__)).'/' . 'webengine.php');

	// Cron System
	$Cron = new Cron();
	$Cron->executeCrons();
	
} catch(Exception $ex) {
	// TODO: logs system
	die($ex->getMessage());
}