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
	
	if(!check($_GET['id'])) redirect('credits/config');
	
	$creditSystem = new CreditSystem();
	$creditSystem->setConfigId($_GET['id']);
	$creditSystem->deleteConfig();
	
	redirect('credits/config');
	
} catch (Exception $ex) {
	
	message('error', $ex->getMessage());
	
}