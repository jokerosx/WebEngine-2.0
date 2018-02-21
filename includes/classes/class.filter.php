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

class Filter {
	
	public static function RemoveAllSpaces($string) {
		return preg_replace('/\s+/', '', $string);
	}
	
	public static function RemoveTrailingSlash($string) {
		return rtrim($string, '/');
	}
	
}