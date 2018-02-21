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
	
	if(!check($_GET['package'])) throw new Exception('Package id not provided.');
	
	$PayPal = new PayPal();
	$PayPal->setId($_GET['package']);
	$PayPal->deletePackage();
	
	redirect('paypal/packages');
	
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}