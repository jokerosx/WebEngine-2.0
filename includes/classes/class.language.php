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

class Language {
	
	private static $languageInfoFile = 'info.json';
	private static $languageFile = 'language.php';
	private static $languageAdminFile = 'language.admincp.php';
	private static $infoFileRequiredElements = array(
		'active',
		'locale',
		'author',
		'website',
		'version',
	);
	
	/**
	 * Phrase
	 * 
	 */
	public static function Phrase($phrase, $args=array()) {
		global $lang;
		if(config('language_debug')) return $phrase;
		if(!array_key_exists($phrase, $lang)) return 'ERROR';
		$result = @vsprintf($lang[$phrase], $args);
		if(!$result) return 'ERROR';
		return $result;
	}
	
	/**
	 * getLanguagePhraseList
	 * 
	 */
	public static function getLanguagePhraseList() {
		global $lang;
		return $lang;
	}
	
	/**
	 * getInstalledLanguagePacks
	 * 
	 */
	public static function getInstalledLanguagePacks() {
		$languagePacks = glob(__PATH_LANGUAGES__ . '*', GLOB_ONLYDIR);
		if(!is_array($languagePacks)) return;
		
		foreach($languagePacks as $languagePack) {
			$languageDir = end(explode('/', $languagePack));
			
			// required language files
			if(!file_exists($languagePack . '/' . self::$languageInfoFile)) continue;
			if(!file_exists($languagePack . '/' . self::$languageFile)) continue;
			if(!file_exists($languagePack . '/' . self::$languageAdminFile)) continue;
			
			// language information
			$languageInfo = self::_loadLanguageInfo($languageDir);
			if(!is_array($languageInfo)) continue;
			
			$result[$languageDir] = $languageInfo;
		}
		
		if(!is_array($result)) return;
		return $result;
	}
	
	/**
	 * getLocaleList
	 * 
	 */
	public static function getLocaleList() {
		$localeList = loadConfig('locales');
		if(!is_array($localeList)) return;
		return $localeList;
	}
	
	/**
	 * getLocaleTitle
	 * 
	 */
	public static function getLocaleTitle($locale) {
		if(!check($locale)) return;
		
		$localeList = self::getLocaleList();
		if(!is_array($localeList)) return;
		
		if(!array_key_exists($locale, $localeList)) return;
		return $localeList[$locale];
	}
	
	/**
	 * switchLanguageStatus
	 * 
	 */
	public static function switchLanguageStatus($languageDir) {
		// load language info
		$languageInfo = self::_loadLanguageInfo($languageDir);
		if(!is_array($languageInfo)) return;
		
		// new status
		$newStatus = $languageInfo['active'] == true ? false : true;
		
		// check write permissions
		$infoFilePath = __PATH_LANGUAGES__ . $languageDir . '/' . self::$languageInfoFile;
		if(!is_writable($infoFilePath)) return;
		
		// update value
		$languageInfo['active'] = $newStatus;
		
		// save file
		$languageInfoJson = json_encode($languageInfo, JSON_PRETTY_PRINT);
		
		$file = fopen($infoFilePath, 'w');
		if(!$file) return;
		fwrite($file, $languageInfoJson);
		fclose($file);
	}
	
	/**
	 * _loadLanguageInfo
	 * 
	 */
	private static function _loadLanguageInfo($languageDir) {
		if(!check($languageDir)) return;
		
		$infoFilePath = __PATH_LANGUAGES__ . $languageDir . '/' . self::$languageInfoFile;
		if(!file_exists($infoFilePath)) return;
		
		$languageFile = file_get_contents($infoFilePath);
		$languageInfo = json_decode($languageFile, true);
		if(!is_array($languageInfo)) return;
		if(!self::_isValidLanguageInfo($languageInfo)) return;
		return $languageInfo;
	}
	
	/**
	 * _isValidLanguageInfo
	 * 
	 */
	private static function _isValidLanguageInfo($languageInfo) {
		if(!is_array($languageInfo)) return;
		if(!is_array(self::$infoFileRequiredElements)) return true;
		
		// required elements
		foreach(self::$infoFileRequiredElements as $requiredKey) {
			if(!array_key_exists($requiredKey, $languageInfo)) return;
		}
		
		// check locale
		if(!self::_isValidLocale($languageInfo['locale'])) return;
		
		return true;
	}
	
	/**
	 * _isValidLocale
	 * 
	 */
	private static function _isValidLocale($locale) {
		if(!check($locale)) return;
		
		$localeList = self::getLocaleList();
		if(!is_array($localeList)) return;
		
		if(!array_key_exists($locale, $localeList)) return;
		return true;
	}
	
}