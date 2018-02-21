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

// check ban id
if(!check($_GET['id'])) redirect('account/profile');

// account ban
$AccountBan = new AccountBan();
$AccountBan->setBanId($_GET['id']);
$banData = $AccountBan->getBanInformation();

// check user id
if($banData['user_id'] != $_SESSION['userid']) redirect('account/profile');

// ban details
echo '<table class="table account-table">';
	echo '<tr>';
		echo '<th>'.lang('account_txt_14').'</th>';
		echo '<td>'.databaseTime($banData['ban_date']).'</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<th>'.lang('account_txt_16').'</th>';
		echo '<td>'.ucfirst($banData['ban_type']).'</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<th>'.lang('account_txt_17').'</th>';
		echo '<td>'.($banData['ban_type'] == 'temporal' ? $AccountBan->formatBanDuration($banData['ban_duration']) : lang('account_txt_20')).'</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<th>'.lang('account_txt_18').'</th>';
		echo '<td>'.($banData['ban_lifted'] == 1 ? '<span class="label label-default">'.lang('account_txt_13',true).'</span>' : '<span class="label label-success">'.lang('account_txt_12',true).'</span>').'</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<th>'.lang('account_txt_19').'</th>';
		echo '<td>'.$banData['ban_reason'].'</td>';
	echo '</tr>';
echo '</table>';