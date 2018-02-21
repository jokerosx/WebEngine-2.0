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

/**
 * check
 * https://github.com/Chevereto/Chevereto-2.X
 */
function check($value) {
	if((@count($value)>0 and !@empty($value) and @isset($value)) || $value=='0') {
		return true;
	}
}

/**
 * redirect
 * 
 */
function redirect($location="") {
	$baseUrl = access == 'admincp' ? __ADMINCP_BASE_URL__ : __BASE_URL__;
	if(!check($location)) {
		header('Location: ' . $baseUrl);
		return;
	}
	if(Validator::Url($location)) {
		header('Location: ' . $location);
		return;
	}
	header('Location: ' . $baseUrl . $location);
	return;
}

/**
 * htmlRedirect
 * 
 */
function htmlRedirect($location="", $delay=5) {
	$baseUrl = access == 'admincp' ? __ADMINCP_BASE_URL__ : __BASE_URL__;
	if(!check($location)) {
		echo '<meta http-equiv="refresh" content="'.$delay.'; URL=\''.$baseUrl.'\'" />';
		return;
	}
	if(Validator::Url($location)) {
		echo '<meta http-equiv="refresh" content="'.$delay.'; URL=\''.$location.'\'" />';
		return;
	}
	echo '<meta http-equiv="refresh" content="'.$delay.'; URL=\''.$baseUrl.$location.'\'" />';
	return;
}

/**
 * isLoggedIn
 * 
 */
function isLoggedIn() {
	if(sessionControl::isLoggedIn()) return true;
	return;
}

/**
 * logOutUser
 * 
 */
function logOutUser() {
	sessionControl::logout();
}

/**
 * message
 * 
 */
function message($type='info', $message="", $title="") {
	switch($type) {
		case 'error':
			$class = ' alert-danger';
		break;
		case 'success':
			$class = ' alert-success';
		break;
		case 'warning':
			$class = ' alert-warning';
		break;
		default:
			$class = ' alert-info';
		break;
	}
	
	if(check($title)) {
		echo '<div class="alert'.$class.'" role="alert"><strong>'.$title.'</strong><br />'.$message.'</div>';
	} else {
		echo '<div class="alert'.$class.'" role="alert">'.$message.'</div>';
	}
}

/**
 * lang
 * 
 */
function lang($phrase, $args=null, $return=true) {
	if(is_array($args)) {
		return Language::Phrase($phrase, $args);
	}
	return Language::Phrase($phrase);
}

/**
 * langf
 * 
 */
function langf($phrase, $args=array(), $print=false) {
	return Language::Phrase($phrase, $args);
}

/**
 * debug
 * https://github.com/Chevereto/Chevereto-2.X
 */
function debug($value) {
	echo '<pre>',print_r($value,1),'</pre>';
}

/**
 * sec_to_hms
 * 
 */
function sec_to_hms($input_seconds=0) {
	$result = sec_to_dhms($input_seconds);
	if(!is_array($result)) return array(0,0,0);
	return array($result[1], $result[2], $result[3]);
}

/**
 * sec_to_dhms
 * 
 */
function sec_to_dhms($input_seconds=0) {
	if($input_seconds < 1) return array(0,0,0,0);
	$days_module = $input_seconds % 86400;
	$days = ($input_seconds-$days_module)/86400;
	$hours_module = $days_module % 3600;
	$hours = ($days_module-$hours_module)/3600;
	$minutes_module = $hours_module % 60;
	$minutes = ($hours_module-$minutes_module)/60;
	$seconds = $minutes_module;
	return array($days,$hours,$minutes,$seconds);
}

/**
 * returnGuildLogo
 * 
 */
function returnGuildLogo($data='', $imgTags=true, $css=null, $size=null) {
	$imgData = config('gmark_bin2hex_enable') ? bin2hex($data) : $data;
	$fileName = $gensInfo[1];
	$image = __BASE_URL__ . 'api/guildlogo.php?data=';
	$image .= $imgData;
	if(check($size)) $image .= '&s=' . $size;
	
	
	if($imgTags) {
		$buildTag = '<img';
		$buildTag .= ' src="'.$image.'"';
		if(check($css)) {
			$buildTag .= ' class="'.$css.'"';
		}
		if(check($size)) {
			$buildTag .= ' width="'.$size.'px"';
			$buildTag .= ' height="'.$size.'px"';
		}
		$buildTag .= '/>';
		return $buildTag;
	}
	return $image;
}

/**
 * getGensRank
 * 
 */
function getGensRank($id=0) {
	$gensRanks = custom('gens_ranks');
	if(!is_array($gensRanks)) return 'Private';
	if(!array_key_exists($id, $gensRanks)) return 'Private';
	return $gensRanks[$id];
}

/**
 * webengineConfigs
 * 
 */
function webengineConfigs() {
	if(!file_exists(__PATH_CONFIGS__ . 'webengine.json')) throw new Exception('WebEngine\'s configuration file doesn\'t exist, please reupload the website files.');
	
	$webengineConfigs = file_get_contents(__PATH_CONFIGS__ . 'webengine.json');
	if(!check($webengineConfigs)) throw new Exception('WebEngine\'s configuration file is empty, please run the installation script.');
	
	return json_decode($webengineConfigs, true);
}

/**
 * config
 * 
 */
function config($config_name, $return = true) {
	global $config;
	return $config[$config_name];
}

/**
 * convertXML
 * 
 */
function convertXML($object) {
	return json_decode(json_encode($object), true);
}

/**
 * loadModuleConfigs
 * 
 */
function loadModuleConfigs($module) {
	global $mconfig;
	if(moduleConfigExists($module)) {
		$xml = simplexml_load_file(__PATH_MODULE_CONFIGS__.$module.'.xml');
		$mconfig = array();
		if($xml) {
			$moduleCONFIGS = convertXML($xml->children());
			$mconfig = $moduleCONFIGS;
		}
	}
}

/**
 * moduleConfigExists
 * 
 */
function moduleConfigExists($module) {
	if(file_exists(__PATH_MODULE_CONFIGS__.$module.'.xml')) {
		return true;
	}
}

/**
 * globalConfigExists
 * 
 */
function globalConfigExists($config_file) {
	if(file_exists(__PATH_CONFIGS__.$config_file.'.xml')) {
		return true;
	}
}

/**
 * mconfig
 * 
 */
function mconfig($configuration) {
	global $mconfig;
	if(@array_key_exists($configuration, $mconfig)) {
		return $mconfig[$configuration];
	} else {
		return null;
	}
}

/**
 * gconfig
 * 
 */
function gconfig($config_file,$return=true) {
	global $gconfig;
	if(globalConfigExists($config_file)) {
		$xml = simplexml_load_file(__PATH_CONFIGS__.$config_file.'.xml');
		$gconfig = array();
		if($xml) {
			$globalCONFIGS = convertXML($xml->children());
			if($return) {
				return $globalCONFIGS;
			} else {
				$gconfig = $globalCONFIGS;
			}
		}
	}
}

/**
 * loadConfigurations
 * 
 */
function loadConfigurations($file) {
	if(!check($file)) return;
	if(!moduleConfigExists($file)) return;
	$xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . $file . '.xml');
	if($xml) return convertXML($xml->children());
	return;
}

/**
 * loadModuleConfig
 * 
 */
function loadModuleConfig($filename) {
	if(!check($filename)) return;
	if(!file_exists(__PATH_MODULE_CONFIGS__ . $filename . '.json')) return;
	$cfg = file_get_contents(__PATH_MODULE_CONFIGS__ . $filename . '.json');
	if(!check($cfg)) return;
	return json_decode($cfg, true);
}

/**
 * loadConfig
 * 
 */
function loadConfig($name="webengine") {
	if(!check($name)) return;
	if(!file_exists(__PATH_CONFIGS__ . $name . '.json')) return;
	$cfg = file_get_contents(__PATH_CONFIGS__ . $name . '.json');
	if(!check($cfg)) return;
	return json_decode($cfg, true);
}

/**
 * returnPlayerAvatar
 * 
 */
function returnPlayerAvatar($code=0, $alt=true, $imgTags=true, $css=null, $width=null, $height=null) {
	$playerClass = custom('character_class');
	if(!is_array($playerClass)) return;
	$fileName = (array_key_exists($code, $playerClass) ? $playerClass[$code][2] : 'avatar.jpg');
	$image = Handler::templateIMG() . 'character-avatars/' . $fileName;
	$name = $playerClass[$code][0];
	
	if($imgTags) {
		$buildTag = '<img';
		$buildTag .= ' src="'.$image.'"';
		if(check($css)) {
			$buildTag .= ' class="'.$css.'"';
		}
		if($alt) {
			$buildTag .= ' data-toggle="tooltip"';
			$buildTag .= ' data-placement="top"';
			$buildTag .= ' title="'.$name.'"';
			$buildTag .= ' alt="'.$name.'"';
		}
		if(check($width)) {
			$buildTag .= ' width="'.$width.'"';
		}
		if(check($height)) {
			$buildTag .= ' height="'.$height.'"';
		}
		$buildTag .= '/>';
		return $buildTag;
	}
	return $image;
}

/**
 * returnMapName
 * 
 */
function returnMapName($id=0) {
	$mapList = custom('map_list');
	if(!is_array($mapList)) return 'Lorencia Bar';
	if(!array_key_exists($id, $mapList)) return 'Lorencia Bar';
	return $mapList[$id];
}

/**
 * returnPkLevel
 * 
 */
function returnPkLevel($id) {
	global $custom;
	
	if(!is_array($custom['pk_level'])) return;
	if(!array_key_exists($id, $custom['pk_level'])) return;
	return $custom['pk_level'][$id];
}

/**
 * returnGensInfo
 * 
 */
function returnGensInfo($code) {
	$gensType = custom('gens_type');
	if(!is_array($gensType)) return;
	if(!array_key_exists($code, $gensType)) return;
	return $gensType[$code];
}

/**
 * returnGensIcon
 * 
 */
function returnGensIcon($code=0, $alt=true, $imgTags=true, $css=null, $width=null, $height=null) {
	$gensInfo = returnGensInfo($code);
	if(!is_array($gensInfo)) return;
	$fileName = $gensInfo[1];
	$image = Handler::templateIMG() . $fileName;
	$name = $gensInfo[0];
	
	if($imgTags) {
		$buildTag = '<img';
		$buildTag .= ' src="'.$image.'"';
		if(check($css)) {
			$buildTag .= ' class="'.$css.'"';
		}
		if($alt) {
			$buildTag .= ' data-toggle="tooltip"';
			$buildTag .= ' data-placement="top"';
			$buildTag .= ' title="'.$name.'"';
			$buildTag .= ' alt="'.$name.'"';
		}
		if(check($width)) {
			$buildTag .= ' width="'.$width.'"';
		}
		if(check($height)) {
			$buildTag .= ' height="'.$height.'"';
		}
		$buildTag .= '/>';
		return $buildTag;
	}
	return $image;
}

/**
 * custom
 * 
 */
function custom($config) {
	global $custom;
	
	if(!is_array($custom)) return;
	if(!array_key_exists($config, $custom)) return;
	return $custom[$config];
}

/**
 * playerClassName
 * 
 */
function playerClassName($class=0, $short=false) {
	$playerClassData = custom('character_class');
	if(!is_array($playerClassData)) return;
	if(!array_key_exists($class, $playerClassData)) return 'Unknown';
	
	if($short) return $playerClassData[$class][1];
	return $playerClassData[$class][0];
}

/**
 * databaseTime
 * 
 */
function databaseTime($datetime) {
	return date("Y-m-d H:i:s", strtotime($datetime) + date("Z"));
}

/**
 * encodeCache
 * 
 */
function encodeCache($data, $pretty=false) {
	if($pretty) return json_encode($data, JSON_PRETTY_PRINT);
	return json_encode($data);
}

/**
 * decodeCache
 * 
 */
function decodeCache($data) {
	return json_decode($data, true);
}

/**
 * updateCache
 * 
 */
function updateCache($fileName, $data) {
	$file = __PATH_CACHE__ . $fileName;
	if(!file_exists($file)) return;
	if(!is_writable($file)) return;
	
	$fp = fopen($file, 'w');
	fwrite($fp, $data);
	fclose($fp);
	return true;
}

/**
 * loadCache
 * 
 */
function loadCache($fileName) {
	$file = __PATH_CACHE__ . $fileName;
	if(!file_exists($file)) return;
	if(!is_readable($file)) return;
	
	$cacheDataRaw = file_get_contents($file);
	if(!check($cacheDataRaw)) return;
	
	$cacheData = decodeCache($cacheDataRaw);
	if(!is_array($cacheData)) return;
	
	return $cacheData;
}

/**
 * playerProfile
 * 
 */
function playerProfile($name, $css=null) {
	$link = __BASE_URL__ . 'profile/player/' . $name;
	
	$buildTag = '<a href="'.$link.'"';
	if(check($css)) {
		$buildTag .= ' class="'.$css.'"';
	}
	$buildTag .= '>';
	$buildTag .= $name;
	$buildTag .= '</a>';
	
	return $buildTag;
}

/**
 * guildProfile
 * 
 */
function guildProfile($name, $css=null) {
	$link = __BASE_URL__ . 'profile/guild/' . $name;
	
	$buildTag = '<a href="'.$link.'"';
	if(check($css)) {
		$buildTag .= ' class="'.$css.'"';
	}
	$buildTag .= '>';
	$buildTag .= $name;
	$buildTag .= '</a>';
	
	return $buildTag;
}

/**
 * facebookProfile
 * 
 */
function facebookProfile($id) {
	return __FACEBOOK_PROFILE_LINK__ . $id;
}

/**
 * googleProfile
 * 
 */
function googleProfile($id) {
	return __GOOGLE_PROFILE_LINK__ . $id;
}

/**
 * adapterConfig
 * 
 */
function adapterConfig($provider, $callback) {
	if(!check($provider)) return;
	if(!check($callback)) return;
	
	$cfg = loadConfig('social');
	if(!is_array($cfg)) return;
	if(!array_key_exists($provider, $cfg['provider'])) return;
	if(!check($cfg['provider'][$provider]['id'])) return;
	if(!check($cfg['provider'][$provider]['secret'])) return;
	
	$adapterConfig = [
		'callback' => Handler::websiteLink($callback),
		'keys' => [
			'id'		=> $cfg['provider'][$provider]['id'],
			'secret'	=> $cfg['provider'][$provider]['secret'],
		]
	];
	
	if(check($cfg['provider'][$provider]['scope'])) {
		$adapterConfig['scope'] = $cfg['provider'][$provider]['scope'];
	}
	
	return $adapterConfig;
}

/**
 * isAdmin
 * 
 */
function isAdmin() {
	if(!check($_SESSION['admin'])) return;
	if($_SESSION['admin'] != true) return;
	return true;
}

/**
 * readableFileSize
 * 
 */
function readableFileSize($size) {
	if($size == 0) return '0B';
	$base = log($size) / log(1024);
	$suffix = array("", "KB", "MB", "GB", "TB");
	$f_base = floor($base);
	return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
}

/**
 * setOfflineMode
 * 
 */
function setOfflineMode($status=false) {
	$webengineConfigurations = webengineConfigs();
	$webengineConfigurations['offline_mode'] = $status;
	$newWebEngineConfig = json_encode($webengineConfigurations, JSON_PRETTY_PRINT);
	$cfgFile = fopen(__PATH_CONFIGS__.'webengine.json', 'w');
	if(!$cfgFile) return;
	if(!fwrite($cfgFile, $newWebEngineConfig)) return;
	if(!fclose($cfgFile)) return;
	return true;
}

/**
 * getCurrencies
 * 
 */
function getCurrencies($currency='') {
	$currencies = loadConfig('currencies');
	if(!is_array($currencies)) return;
	if(!check($currency)) return $currencies;
	if(!array_key_exists($currency, $currencies)) return;
	return $currencies[$currency];
}