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

echo '<div class="panel panel-sidebar panel-usercp">';
	echo '<div class="panel-heading">';
		echo '<h3 class="panel-title">'.lang('usercp_menu_title').'</h3>';
	echo '</div>';
	echo '<div class="panel-body">';
			templateBuildUsercp();
	echo '</div>';
echo '</div>';