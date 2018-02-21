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
	
	$Account = new Account();
	$onlineAccounts = $Account->getOnlineAccountList();
	if(!is_array($onlineAccounts)) throw new Exception('error');
	
	$Player = new Player();
	
	foreach($onlineAccounts as $onlineAccount) {
		$Player->setUsername($onlineAccount[_CLMN_MS_MEMBID_]);
		$playerIDC = $Player->getAccountPlayerIDC();
		if(!check($playerIDC)) continue;
		
		$result[] = $playerIDC;
	}
	
	if(!is_array($result)) throw new Exception('error');
	
	$cacheData = encodeCache($result);
	updateCache('online_players.cache', $cacheData);
	
} catch(Exception $ex) {
	// TODO: logs system
}