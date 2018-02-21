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

// WebEngine CMS Version
define('__WEBENGINE_VERSION__', '2.0.0');

// Encoding
@ini_set('default_charset', 'utf-8');

// Server Time
// http://php.net/manual/en/timezones.php
//date_default_timezone_set('America/Los_Angeles');
//date_default_timezone_set('America/Chicago');
date_default_timezone_set('UTC');

// Server Variables (CLI)
if(!isset($_SERVER['SCRIPT_NAME'])) $_SERVER['SCRIPT_NAME'] = '';
if(!isset($_SERVER['SCRIPT_FILENAME'])) $_SERVER['SCRIPT_FILENAME'] = '';

// Global Paths
define('HTTP_HOST', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'CLI');
define('SERVER_PROTOCOL', (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ) ? 'https://' : 'http://');
define('__ROOT_DIR__', rtrim(str_replace('\\','/', dirname(__DIR__)), '/') . '/');
define('__RELATIVE_ROOT__', rtrim((access == 'admincp' ? dirname(dirname($_SERVER['SCRIPT_NAME'])) : dirname($_SERVER['SCRIPT_NAME'])), '\/') . '/');
define('__BASE_URL__', SERVER_PROTOCOL.HTTP_HOST.__RELATIVE_ROOT__);

// Private Paths
define('__PATH_INCLUDES__', __ROOT_DIR__.'includes/');
define('__PATH_TEMPLATES__', __ROOT_DIR__.'templates/');
define('__PATH_LANGUAGES__', __PATH_INCLUDES__ . 'languages/');
define('__PATH_CLASSES__', __PATH_INCLUDES__.'classes/');
define('__PATH_FUNCTIONS__', __PATH_INCLUDES__.'functions/');
define('__PATH_MODULES__', __ROOT_DIR__.'modules/');
define('__PATH_MODULES_USERCP__', __PATH_MODULES__.'usercp/');
define('__PATH_EMAILS__', __PATH_INCLUDES__.'emails/');
define('__PATH_CACHE__', __PATH_INCLUDES__.'cache/');
define('__PATH_ADMINCP__', __ROOT_DIR__.'admincp/');
define('__PATH_ADMINCP_INCLUDES__', __PATH_ADMINCP__.'includes/');
define('__PATH_ADMINCP_MODULES__', __PATH_ADMINCP__.'modules/');
define('__PATH_ADMINCP_TEMPLATES__', __PATH_ADMINCP__.'templates/');
define('__PATH_ADMINCP_MODULE_SETTINGS__', __PATH_ADMINCP_MODULES__.'modulemanager/module_settings/');
define('__PATH_NEWS_CACHE__', __PATH_CACHE__.'news/');
define('__PATH_PLUGINS__', __PATH_INCLUDES__.'plugins/');
define('__PATH_CONFIGS__', __PATH_INCLUDES__.'config/');
define('__PATH_MODULE_CONFIGS__', __PATH_CONFIGS__.'modules/');
define('__PATH_CRON__', __PATH_INCLUDES__.'cron/');

// Public Paths
define('__ADMINCP_BASE_URL__', __BASE_URL__ . 'admincp/');
define('__ADMINCP_TEMPLATES_BASE_URL__', __ADMINCP_BASE_URL__.'templates/');
define('__TEMPLATES_BASE_URL__', __BASE_URL__ . 'templates/');

// Libraries
if(!@include_once(__PATH_CLASSES__ . 'class.database.php')) throw new Exception('Could not load class (database).');
if(!@include_once(__PATH_CLASSES__ . 'class.sqlite.php')) throw new Exception('Could not load class (sqlite).');
if(!@include_once(__PATH_CLASSES__ . 'class.handler.php')) throw new Exception('Could not load class (handler).');
if(!@include_once(__PATH_CLASSES__ . 'class.validator.php')) throw new Exception('Could not load class (validator).');
if(!@include_once(__PATH_CLASSES__ . 'class.filter.php')) throw new Exception('Could not load class (filter).');
if(!@include_once(__PATH_CLASSES__ . 'class.vote.php')) throw new Exception('Could not load class (vote).');
if(!@include_once(__PATH_CLASSES__ . 'class.player.php')) throw new Exception('Could not load class (player).');
if(!@include_once(__PATH_CLASSES__ . 'class.player.reset.php')) throw new Exception('Could not load class (player.reset).');
if(!@include_once(__PATH_CLASSES__ . 'class.player.unstick.php')) throw new Exception('Could not load class (player.unstick).');
if(!@include_once(__PATH_CLASSES__ . 'class.player.clearpk.php')) throw new Exception('Could not load class (player.clearpk).');
if(!@include_once(__PATH_CLASSES__ . 'class.player.resetstats.php')) throw new Exception('Could not load class (player.resetstats).');
if(!@include_once(__PATH_CLASSES__ . 'class.player.addstats.php')) throw new Exception('Could not load class (player.addstats).');
if(!@include_once(__PATH_CLASSES__ . 'class.player.clearskilltree.php')) throw new Exception('Could not load class (player.clearskilltree).');
if(!@include_once(__PATH_CLASSES__ . 'class.player.search.php')) throw new Exception('Could not load class (player.search).');
if(!@include_once(__PATH_CLASSES__ . 'phpmailer/PHPMailerAutoload.php')) throw new Exception('Could not load class (phpmailer).');
if(!@include_once(__PATH_CLASSES__ . 'class.rankings.php')) throw new Exception('Could not load class (rankings).');
if(!@include_once(__PATH_CLASSES__ . 'class.news.php')) throw new Exception('Could not load class (news).');
if(!@include_once(__PATH_CLASSES__ . 'class.credits.php')) throw new Exception('Could not load class (credits).');
if(!@include_once(__PATH_CLASSES__ . 'class.email.php')) throw new Exception('Could not load class (email).');
if(!@include_once(__PATH_CLASSES__ . 'class.account.php')) throw new Exception('Could not load class (account).');
if(!@include_once(__PATH_CLASSES__ . 'class.account.login.php')) throw new Exception('Could not load class (account.login).');
if(!@include_once(__PATH_CLASSES__ . 'class.account.register.php')) throw new Exception('Could not load class (account.register).');
if(!@include_once(__PATH_CLASSES__ . 'class.account.password.php')) throw new Exception('Could not load class (account.password).');
if(!@include_once(__PATH_CLASSES__ . 'class.account.email.php')) throw new Exception('Could not load class (account.email).');
if(!@include_once(__PATH_CLASSES__ . 'class.account.search.php')) throw new Exception('Could not load class (account.search).');
if(!@include_once(__PATH_CLASSES__ . 'class.account.ban.php')) throw new Exception('Could not load class (account.ban).');
if(!@include_once(__PATH_CLASSES__ . 'class.account.preferences.php')) throw new Exception('Could not load class (account.preferences).');
if(!@include_once(__PATH_CLASSES__ . 'class.session.php')) throw new Exception('Could not load class (session).');
if(!@include_once(__PATH_CLASSES__ . 'class.cron.php')) throw new Exception('Could not load class (cron).');
if(!@include_once(__PATH_CLASSES__ . 'class.language.php')) throw new Exception('Could not load class (language).');
if(!@include_once(__PATH_CLASSES__ . 'class.admin.php')) throw new Exception('Could not load class (admin).');
if(!@include_once(__PATH_CLASSES__ . 'class.modulemanager.php')) throw new Exception('Could not load class (modulemanager).');
if(!@include_once(__PATH_CLASSES__ . 'class.downloads.php')) throw new Exception('Could not load class (downloads).');
if(!@include_once(__PATH_CLASSES__ . 'class.paypal.php')) throw new Exception('Could not load class (paypal).');

// Functions
if(!@include_once(__PATH_INCLUDES__ . 'functions.php')) throw new Exception('Could not load functions.');

// Recaptcha
if(!@include_once(__PATH_CLASSES__ . 'recaptcha/autoload.php')) throw new Exception('Could not load class (recaptcha).');

// HybridAuth
if(!@include_once(__PATH_CLASSES__ . 'hybridauth/autoload.php')) throw new Exception('Could not load class (hybridauth).');

// PayPal SDK
if(!@include_once(__PATH_CLASSES__ . 'paypal/PaypalIPN.php')) throw new Exception('Could not load class (paypal).');

// Admincp Functions
if(access == 'admincp') if(!@include_once(__PATH_ADMINCP_INCLUDES__ . 'functions.php')) throw new Exception('Could not load admincp functions.');

// Configurations
$config = webengineConfigs();

// System Status
if(!$config['system_active']) {
	throw new Exception('The website is currently under maintenance, please try again later.');
}

// Debug Mode
if($config['debug']) {
	ini_set('display_errors', true);
	error_reporting(E_ALL & ~E_NOTICE);
} else {
	ini_set('display_errors', false);
	error_reporting(0);
}

// Admincp Configurations
if(access == 'admincp') {
	if(!@include_once(__PATH_ADMINCP_INCLUDES__ . 'config.php')) throw new Exception('Could not load admincp configuration file.');
}

// WebEngine CMS Tables Prefix
define('WE_TABLE_PREFIX', $config['SQL_TABLE_PREFIX']);

// Table Definitions
if(!@include_once(__PATH_CONFIGS__ . 'webengine.tables.php')) throw new Exception('Could not load the table definitions.');
if(!@include_once(__PATH_CONFIGS__ . strtolower($config['server_files']) . '.tables.php')) throw new Exception('Could not load the table definitions.');

// Social
define('__FACEBOOK_PROFILE_LINK__', 'https://www.facebook.com/app_scoped_user_id/');
define('__GOOGLE_PROFILE_LINK__', 'https://plus.google.com/');

// WebEngine CMS Official
define('__WEBENGINE_WEBSITE__', 'https://webenginecms.org/');
define('__WEBENGINE_NAME__', 'WebEngine');

// Template
Handler::renderTemplate();