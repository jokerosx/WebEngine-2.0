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

class News {
	
	private $_newsCacheFile = 'news.cache';
	private $_newsCacheDir;
	private $_titleMinLen = 1;
	private $_titleMaxLen = 100;
	private $_authorMinLen = 1;
	private $_authorMaxLen = 50;
	private $_dateDisplay = "F j, Y";
	private $_requestUrlRegex = '/^([0-9]+)-([a-z0-9\-]+)$/';
	
	private $_id;
	private $_title;
	private $_content;
	private $_author;
	private $_date;
	private $_requestUrl;
	private $_isSingleNews = false;
	
	private $_newsData;
	
	function __construct() {
		
		// news cache file
		if(!file_exists(__PATH_CACHE__.$this->_newsCacheFile)) {
			if(!$this->_createNewsCacheFile()) throw new Exception(lang('error_203'));
		}
		
		if(!is_writable(__PATH_CACHE__.$this->_newsCacheFile)) throw new Exception(lang('error_204'));
		
		// news cache directory
		$this->_newsCacheDir = __PATH_NEWS_CACHE__;
		if(!is_writable($this->_newsCacheDir)) throw new Exception(lang('error_205'));
		
		// database object
		$this->we = Handler::loadDB('WebEngine');
		
	}
	
	/**
	 * setId
	 * 
	 */
	public function setId($value) {
		if(!Validator::UnsignedNumber($value)) throw new Exception(lang('error_206'));
		$this->_id = $value;
	}
	
	/**
	 * setTitle
	 * 
	 */
	public function setTitle($value) {
		if(!Validator::Length($value, $this->_titleMaxLen, $this->_titleMinLen)) throw new Exception(lang('error_207'));
		$this->_title = $value;
	}
	
	/**
	 * setContent
	 * 
	 */
	public function setContent($value) {
		$this->_content = $value;
	}
	
	/**
	 * setAuthor
	 * 
	 */
	public function setAuthor($value) {
		if(!Validator::Length($value, $this->_authorMaxLen, $this->_authorMinLen)) throw new Exception(lang('error_208'));
		$this->_author = $value;
	}
	
	/**
	 * setDate
	 * 
	 */
	public function setDate($value) {
		$this->_date = $value;
	}
	
	/**
	 * setRequestUrl
	 * 
	 */
	public function setRequestUrl($request) {
		if(!preg_match($this->_requestUrlRegex, $request)) return;
		$this->_requestUrl = $request;
		$this->_isSingleNews = true;
	}
	
	/**
	 * publishNews
	 * 
	 */
	public function publishNews() {
		if(!check($this->_title)) throw new Exception(lang('error_4'));
		if(!check($this->_content)) throw new Exception(lang('error_4'));
		if(!check($this->_author)) throw new Exception(lang('error_4'));
		
		$data = array(
			'title' => $this->_title,
			'content' => $this->_content,
			'author' => $this->_author
		);
		
		$query = "INSERT INTO "._WE_NEWS_." (news_title, news_content, news_author, news_date) VALUES (:title, :content, :author, CURRENT_TIMESTAMP)";
		
		$result = $this->we->query($query, $data);
		if(!$result) throw new Exception(lang('error_209'));
		
		if(!$this->_updateNewsCache()) throw new Exception(lang('error_210'));
	}
	
	/**
	 * editNews
	 * 
	 */
	public function editNews() {
		if(!check($this->_id)) throw new Exception(lang('error_4'));
		if(!check($this->_title)) throw new Exception(lang('error_4'));
		if(!check($this->_content)) throw new Exception(lang('error_4'));
		if(!check($this->_author)) throw new Exception(lang('error_4'));
		
		$data = array(
			'id' => $this->_id,
			'title' => $this->_title,
			'content' => $this->_content,
			'author' => $this->_author
		);
		
		$query = "UPDATE "._WE_NEWS_." SET news_title = :title, news_content = :content, news_author = :author WHERE news_id = :id";
		
		$result = $this->we->query($query, $data);
		if(!$result) throw new Exception(lang('error_211'));
		
		if(!$this->_updateNewsCache()) throw new Exception(lang('error_212'));
	}
	
	/**
	 * deleteNews
	 * 
	 */
	public function deleteNews() {
		if(!check($this->_id)) throw new Exception(lang('error_4'));
		$result = $this->we->query("DELETE FROM "._WE_NEWS_." WHERE news_id = ?", array($this->_id));
		if(!$result) throw new Exception(lang('error_213'));
		if(!$this->_updateNewsCache()) throw new Exception(lang('error_214'));
	}
	
	/**
	 * getNewsList
	 * 
	 */
	public function getNewsList() {
		if($this->_isSingleNews) {
			return $this->_loadSingleNewsListCache();
		}
		return $this->_loadNewsListCache();
	}
	
	/**
	 * getUncachedNewsList
	 * 
	 */
	public function getUncachedNewsList() {
		$this->_loadNews();
		return $this->_newsData;
	}
	
	/**
	 * loadNewsContentCache
	 * 
	 */
	public function loadNewsContentCache($file) {
		$filePath = $this->_newsCacheDir . $file . '.cache';
		if(!file_exists($filePath)) return;
		
		$content = file_get_contents($filePath);
		if(!check($content)) return;
		
		return $content;
	}
	
	/**
	 * loadSingleNewsById
	 * 
	 */
	public function loadSingleNewsById() {
		if(!check($this->_id)) return;
		$this->_loadNews($this->_id);
		return $this->_newsData;
	}
	
	/**
	 * _createNewsCacheFile
	 * 
	 */
	private function _createNewsCacheFile() {
		if(!is_writable(__PATH_CACHE__)) return;
		
		$fp = fopen(__PATH_CACHE__.$this->_newsCacheFile, 'w');
		if(!$fp) return;
		
		fclose($fp);
		return true;
	}
	
	/**
	 * _loadNews
	 * 
	 */
	private function _loadNews($id="") {
		if(check($id)) {
			$result = $this->we->queryFetchSingle("SELECT * FROM "._WE_NEWS_." WHERE news_id = ?", array($id));
		} else {
			$result = $this->we->queryFetch("SELECT * FROM "._WE_NEWS_." ORDER BY news_id DESC");
		}
		if(!is_array($result)) return;
		
		$this->_newsData = $result;
	}
	
	/**
	 * _buildFriendlyUrlTitle
	 * 
	 */
	private function _buildFriendlyUrlTitle($id, $title) {
		$result = strtolower($title);
		$result = preg_replace("/[^[:alnum:][:space:]]/u", '', $result);
		$result = preg_replace("/[\s-]+/", " ", $result);
		$result = preg_replace("/[\s_]/", "-", $result);
		$result = $id . '-' . $result;
		
		return $result;
	}
	
	/**
	 * _buildNewsCache
	 * 
	 */
	private function _buildNewsCache() {
		$this->_loadNews();
		if(!is_array($this->_newsData)) return;
		
		$result = array();
		foreach($this->_newsData as $newsData) {
			$title = $this->_buildFriendlyUrlTitle($newsData['news_id'],$newsData['news_title']);
			$result[] = array(
				'id' => $newsData['news_id'],
				'title' => $newsData['news_title'],
				'author' => $newsData['news_author'],
				'date' => date($this->_dateDisplay, strtotime(databaseTime($newsData['news_date']))),
				'comments' => $newsData['news_comments'],
				'file' => $title
			);
		}
		
		return $result;
	}
	
	/**
	 * _updateNewsCache
	 * 
	 */
	private function _updateNewsCache() {
		$newsListCache = $this->_buildNewsCache();
		
		// news list cache file
		$fp = fopen(__PATH_CACHE__.$this->_newsCacheFile, 'w');
		if(!$fp) return;
		if(is_array($newsListCache)) fwrite($fp, encodeCache($newsListCache));
		fclose($fp);
		
		if(!is_array($newsListCache)) return;
		
		// delete all news cache files
		foreach(glob($this->_newsCacheDir."/*.*") as $filename) {
			if(is_file($filename)) {
				unlink($filename);
			}
		}
		
		// individual news cache files
		foreach($this->_newsData as $newsData) {
			$title = $this->_buildFriendlyUrlTitle($newsData['news_id'],$newsData['news_title']);
			$filePath = $this->_newsCacheDir . $title . '.cache';
			if(file_exists($filePath)) {
				if(!is_writable($filePath)) return;
			}
			
			$fp = fopen($filePath, 'w');
			if(!$fp) return;
			fwrite($fp, $newsData['news_content']);
			fclose($fp);
			
		}
		
		return true;
	}
	
	/**
	 * _loadNewsListCache
	 * 
	 */
	private function _loadNewsListCache() {
		$result = file_get_contents(__PATH_CACHE__.$this->_newsCacheFile);
		$result = decodeCache($result);
		if(!is_array($result)) return;
		
		return $result;
	}
	
	/**
	 * _loadSingleNewsListCache
	 * 
	 */
	private function _loadSingleNewsListCache() {
		$newsList = $this->_loadNewsListCache();
		if(!is_array($newsList)) return;
		foreach($newsList as $newsData) {
			if($newsData['file'] == $this->_requestUrl) return array($newsData);
		}
		return;
	}
	
}