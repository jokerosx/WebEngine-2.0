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

// Events block
?>
<script type="text/javascript">
function eventstime(lasttime, repeattime, showid, opentime) {
	if (lasttime < 0) lasttime = repeattime-1;
	if (lasttime <= opentime) {
		document.getElementById(showid).innerHTML = "Aberto";
		setTimeout('eventstime('+(lasttime-1)+', '+repeattime+', \''+showid+'\', '+opentime+');', 999);
	} else {
		var secs = lasttime % 60;
		if (secs < 10) secs = '0'+secs;
		var lasttime1 = (lasttime - secs) / 60;
		var mins = lasttime1 % 60;
		if (mins < 10) mins = '0'+mins;
		lasttime1 = (lasttime1 - mins) / 60;
		var hours = lasttime1 % 24;
		var days = (lasttime1 - hours) / 24;
		if (days > 1) days = days+' dias ';
		else if (days > 0) days = days+' dia ';
		document.getElementById(showid).innerHTML = days+hours+':'+mins+':'+secs;
		setTimeout('eventstime('+(lasttime-1)+', '+repeattime+', \''+showid+'\', '+opentime+');', 999);
	}
}
</script>

<?
echo '<div class="panel panel-sidebar">';
	echo '<div class="panel-heading">';
		echo '<h3 class="panel-title">Horarios de Eventos</h3>';
	echo '</div>';
echo '<div class="panel-body">';
echo '<table class="sidebar-srvinfo" cellspacing="0" cellpadding="0">';

$eventtime[1]['name']			= 'Blood Castle';
$eventtime[1]['start']			= 'Jan 01,	2018 00:10:00';
$eventtime[1]['repeattime']		= '7200';
$eventtime[1]['opentime']		= '300';

$eventtime[2]['name']			= 'Devil Square';
$eventtime[2]['start']			= 'Jan 01,	2018 03:10:00';
$eventtime[2]['repeattime']		= '14400';
$eventtime[2]['opentime']		= '300';

$eventtime[3]['name']			= 'Chaos Castle';
$eventtime[3]['start']			= 'Jan 01,	2018 01:10:00';
$eventtime[3]['repeattime']		= '7200';
$eventtime[3]['opentime']		= '300';

$eventtime[4]['name']			= 'Golden Invasion';
$eventtime[4]['start']			= 'Jan 01,	2018 00:00:00';
$eventtime[4]['repeattime']		= '14400';
$eventtime[4]['opentime']		= '300';

$eventtime[5]['name']			= 'Ilusion Temple';
$eventtime[5]['start']			= 'Jan 01,	2018 01:50:00';
$eventtime[5]['repeattime']		= '28800';
$eventtime[5]['opentime']		= '300';

$eventtime[6]['name']			= 'Ice Queen';
$eventtime[6]['start']			= 'Jan 01,	2018 00:40:00';
$eventtime[6]['repeattime']		= '21600';
$eventtime[6]['opentime']		= '300';

$eventtime[7]['name']			= 'Moss Merchant';
$eventtime[7]['start']			= 'Jan 01,	2018 03:15:00';
$eventtime[7]['repeattime']		= '25200';
$eventtime[7]['opentime']		= '300';

$eventtime[8]['name']			= 'White Wizard';
$eventtime[8]['start']			= 'Jan 01,	2018 03:20:00';
$eventtime[8]['repeattime']		= '25200';
$eventtime[8]['opentime']		= '300';

$eventtime[9]['name']			= 'Skeleton King';
$eventtime[9]['start']			= 'Jan 01,	2018 04:40:00';
$eventtime[9]['repeattime']		= '21600';
$eventtime[9]['opentime']		= '300';

$eventtime[10]['name']			= 'Dark Monsters';
$eventtime[10]['start']			= 'Jan 01,	2018 03:40:00';
$eventtime[10]['repeattime']	= '21600';
$eventtime[10]['opentime']		= '300';

$eventtime[11]['name']			= 'Bloody Monsters';
$eventtime[11]['start']			= 'Jan 01,	2018 01:20:00';
$eventtime[11]['repeattime']	= '21600';
$eventtime[11]['opentime']		= '300';

$eventtime[11]['name']			= 'Barlog';
$eventtime[11]['start']			= 'Jan 01,	2018 05:40:00';
$eventtime[11]['repeattime']	= '21600';
$eventtime[11]['opentime']		= '300';

$eventtime[12]['name']			= 'Zaikan';
$eventtime[12]['start']			= 'Jan 01,	2018 03:00:00';
$eventtime[12]['repeattime']	= '21600';
$eventtime[12]['opentime']		= '300';

$eventtime[13]['name']			= 'Great Golden Dragon';
$eventtime[13]['start']			= 'Jan 01,	2018 22:50:00';
$eventtime[13]['repeattime']	= '86400';
$eventtime[13]['opentime']		= '300';

$eventtime[14]['name']			= 'Crywolf Siege';
$eventtime[14]['start']			= 'Jan 05,	2018 19:45:00';
$eventtime[14]['repeattime']	= '604800';
$eventtime[14]['opentime']		= '300';

define('WEBSITE_REAL_TIME', time()+3600);

$i = 0;
foreach ($eventtime as $value) {
	$i++;
	$bc_remain = $value['repeattime'] - ((WEBSITE_REAL_TIME - strtotime($value['start'])) % $value['repeattime']);
	$startevents .= 'eventstime('.$bc_remain.', '.$value['repeattime'].', \'event'.$i.'\', '.$value['opentime'].'); ';
	echo '
    <tr>
      <td height="21px"><span>'.$value['name'].'</span></td>
      <td height="21px"><span id="event'.$i.'"></span></td>
    </tr>';
}
echo '<script type="text/javascript">'.$startevents.'</script> </table> </div> </div>';
?>
<style>
.sidebar-srvinfo {
	width: 100%;
	padding: 0px;
}
.sidebar-srvinfo tr td {
	height: 30px;

}
.sidebar-srvinfo tr td:first-child {
	font-weight: 700;
}
.sidebar-srvinfo tr:last-child td {
	border: 0px;
</style>