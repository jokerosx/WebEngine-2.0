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

class WebEngineDatabase extends database {

	function __construct($database='webengine.db') {
		try {
			
			$this->db = new PDO('sqlite:' . __PATH_INCLUDES__ . $database);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		} catch (PDOException $e) {
			$this->dead = true;
			$this->error = "PDOException: ".$e->getMessage();
		}
		
	}

}