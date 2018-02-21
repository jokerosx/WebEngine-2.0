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

// Access
define('access', 'index');

try {
	
	// Load WebEngine CMS
	if(!@include_once(rtrim(str_replace('\\','/', __DIR__), '/') . '/includes/webengine.php')) throw new Exception('Could not load WebEngine CMS.');
	
} catch (Exception $ex) {
	
	$errorPage = file_get_contents(rtrim(str_replace('\\','/', __DIR__), '/') . '/includes/error.html');
	echo str_replace("{ERROR_MESSAGE}", $ex->getMessage(), $errorPage);
	
}
