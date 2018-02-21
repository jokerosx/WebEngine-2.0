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
	
	if(!check($_GET['username'])) throw new Exception('Missing admin username.');
	Admin::removeAdmin($_GET['username']);
	
	redirect('admins/list');
	
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}