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
	
	if(!check($_GET['id'])) throw new Exception('The ban id is missing.');
	if(!check($_GET['username'])) throw new Exception('The username is missing.');
	
	$BanSystem = new AccountBan();
	$BanSystem->setBanId($_GET['id']);
	$BanSystem->lift();
	
	redirect('account/profile/username/' . $_GET['username']);

} catch(Exception $ex) {
	message('error', $ex->getMessage());
}