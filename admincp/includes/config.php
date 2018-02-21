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

$config['admincp_sidebar'] = array(
	'home' => array(
		'title' => 'admincp_sidebar_1',
		'icon' => 'pe-7s-home',
	),
	'news' => array(
		'title' => 'admincp_sidebar_2',
		'icon' => 'pe-7s-news-paper',
		'modules' => array(
			'publish' => 'admincp_sidebar_3',
			'manager' => 'admincp_sidebar_4',
		),
	),
	'account' => array(
		'title' => 'admincp_sidebar_5',
		'icon' => 'pe-7s-id',
		'modules' => array(
			'search' => 'admincp_sidebar_6',
			'list' => 'admincp_sidebar_7',
			'online' => 'admincp_sidebar_8',
			'new' => 'admincp_sidebar_9',
			'topvotes' => 'admincp_sidebar_10',
			'banned' => 'admincp_sidebar_11',
			//'topcredits' => 'admincp_sidebar_12',
			'empty' => 'admincp_sidebar_13',
			'unverified' => 'admincp_sidebar_45',
		),
	),
	'character' => array(
		'title' => 'admincp_sidebar_14',
		'icon' => 'pe-7s-users',
		'modules' => array(
			'search' => 'admincp_sidebar_6',
			//'toplevel' => 'admincp_sidebar_15',
			//'toprebirth' => 'admincp_sidebar_16',
		),
	),
	'bans' => array(
		'title' => 'admincp_sidebar_17',
		'icon' => 'pe-7s-shield',
		'modules' => array(
			//'search' => 'admincp_sidebar_6',
			'new' => 'admincp_sidebar_18',
			'list' => 'admincp_sidebar_48',
			'active' => 'admincp_sidebar_49',
			'latest' => 'admincp_sidebar_19',
		),
	),
	'credits' => array(
		'title' => 'admincp_sidebar_20',
		'icon' => 'pe-7s-cash',
		'modules' => array(
			'config' => 'admincp_sidebar_21',
			'manager' => 'admincp_sidebar_22',
			'logs' => 'admincp_sidebar_23',
		),
	),
	'paypal' => array(
		'title' => 'admincp_sidebar_55',
		'icon' => 'pe-7s-angle-right',
		'modules' => array(
			'settings' => 'admincp_sidebar_58',
			'packages' => 'admincp_sidebar_56',
			'logs' => 'admincp_sidebar_57',
		),
	),
	'configuration' => array(
		'title' => 'admincp_sidebar_27',
		'icon' => 'pe-7s-config',
		'modules' => array(
			'database' => 'admincp_sidebar_28',
			'website' => 'admincp_sidebar_29',
			'admins' => 'admincp_sidebar_32',
			'ipblock' => 'admincp_sidebar_31',
			//'permissions' => 'admincp_sidebar_33',
			'navmenu' => 'admincp_sidebar_34',
			'usermenu' => 'admincp_sidebar_35',
			'downloads' => 'admincp_sidebar_26',
			'votesystem' => 'admincp_sidebar_25',
			'recaptcha' => 'admincp_sidebar_51',
			'social' => 'admincp_sidebar_52',
		),
	),
	'modulemanager' => array(
		'title' => 'admincp_sidebar_46',
		'icon' => 'pe-7s-photo-gallery',
		'modules' => array(
			'settingsmanager' => 'admincp_sidebar_24',
			'list' => 'admincp_sidebar_47',
			'new' => 'admincp_sidebar_50',
		),
	),
	'language' => array(
		'title' => 'admincp_sidebar_36',
		'icon' => 'pe-7s-world',
		'modules' => array(
			'list' => 'admincp_sidebar_37',
			'phrases' => 'admincp_sidebar_38',
		),
	),
	'email' => array(
		'title' => 'admincp_sidebar_53',
		'icon' => 'pe-7s-mail',
		'modules' => array(
			'settings' => 'admincp_sidebar_30',
			'templates' => 'admincp_sidebar_54',
		),
	),
	//'plugins' => array(
	//	'title' => 'admincp_sidebar_39',
	//	'icon' => 'pe-7s-plugin',
	//	'modules' => array(
	//		'manager' => 'admincp_sidebar_40',
	//		'install' => 'admincp_sidebar_41',
	//	),
	//),
	'cron' => array(
		'title' => 'admincp_sidebar_42',
		'icon' => 'pe-7s-timer',
		'modules' => array(
			'new' => 'admincp_sidebar_43',
			'manager' => 'admincp_sidebar_44',
		),
	),
);