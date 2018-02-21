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
	
	if(!check($_GET['id'])) throw new Exception('News id not provided.');
	
	$News = new News();
	$News->setId($_GET['id']);
	$News->deleteNews();
	
	redirect('news/manager');
	
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}