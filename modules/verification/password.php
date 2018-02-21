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

// module configs
$cfg = loadModuleConfig('account.password');
if(!is_array($cfg)) throw new Exception(lang('error_66',true));

try {
	if(!check($_GET['user'], $_GET['key'])) redirect();
	
	$AccountPassword = new AccountPassword();
	$AccountPassword->setUsername($_GET['user']);
	$AccountPassword->setVerificationKey($_GET['key']);
	$AccountPassword->verifyPassword();

	message('success', lang('success_2',true));
	if($cfg['send_new_password_email']) {
		message('success', lang('success_4',true));
	}
	
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}