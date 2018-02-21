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
	$totalAccounts = $Account->getTotalAccountCount();
	$totalOnline = $Account->getTotalOnlineAccountCount();
	
	$Player = new Player();
	$totalPlayers = $Player->getTotalPlayerCount();
	$totalGuilds = $Player->getTotalGuildCount();
	
	$result = array(
		'total_accounts' => $totalAccounts,
		'total_online' => $totalOnline,
		'total_players' => $totalPlayers,
		'total_guilds' => $totalGuilds
	);
	
	$cacheData = encodeCache($result);
	updateCache('server_info.cache', $cacheData);
	
} catch(Exception $ex) {
	// TODO: logs system
}