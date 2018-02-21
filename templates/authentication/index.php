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

// check file access
if(!defined('access') or !access) die();

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?php echo Handler::websiteTitle(); ?></title>
		<meta name="generator" content="WebEngine <?php echo Handler::getWebEngineVersion(); ?>"/>
		<meta name="author" content="<?php echo Handler::getWebEngineAuthor(); ?>"/>
		<meta name="description" content="<?php echo Handler::getWebsiteDescription(); ?>"/>
		<meta name="keywords" content="<?php echo Handler::getWebsiteKeywords(); ?>"/>
		<link rel="shortcut icon" href="<?php echo Handler::templateBase(); ?>favicon.ico"/>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link href="<?php echo Handler::templateCSS(); ?>main.css" rel="stylesheet" media="screen">
		<link href="<?php echo Handler::templateCSS(); ?>override.css" rel="stylesheet" media="screen">
	</head>
	<body>
		
		<div class="logo">
			<a href="<?php echo Handler::websiteLink(); ?>"><img src="<?php echo Handler::templateIMG(); ?>logo.png" /></a>
		</div>
		<div class="container">
			<div class="close-bar">
				<a href="<?php echo Handler::websiteLink(); ?>"><img src="<?php echo Handler::templateIMG(); ?>close.png" /></a>
			</div>
			<div class="content">
				<?php Handler::loadModule(); ?>
			</div>
		</div>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="<?php echo Handler::templateJS(); ?>main.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>
</html>