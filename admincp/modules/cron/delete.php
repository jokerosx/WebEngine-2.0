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
	
	if(!check($_GET['id'])) throw new Exception('The id is required to delete a cron task.');
	
	$Cron = new Cron();
	$Cron->setId($_GET['id']);
	$Cron->removeCron();
	
	redirect('cron/manager');
	
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}