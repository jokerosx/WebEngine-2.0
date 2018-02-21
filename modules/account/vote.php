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

// module configs
$cfg = loadModuleConfig('account.vote');
if(!is_array($cfg)) throw new Exception(lang('error_66',true));

$vote = new Vote();

if(check($_POST['submit'])) {
	try {
		$vote->setUserid($_SESSION['userid']);
		$vote->setIp($_SERVER['REMOTE_ADDR']);
		$vote->setVotesiteId($_POST['voting_site_id']);
		$vote->vote();
	} catch (Exception $ex) {
		message('error', $ex->getMessage());
	}
}

echo '<table class="table table-striped">';
	echo '<thead>';
	echo '<tr>';
		echo '<th class="text-center">'.lang('vfc_txt_1',true).'</th>';
		echo '<th class="text-center">'.lang('vfc_txt_2',true).'</th>';
		echo '<th></th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	$vote_sites = $vote->retrieveVotesites();
	if(is_array($vote_sites)) {
		foreach($vote_sites as $thisVotesite) {
			echo '<form action="" method="post">';
				echo '<input type="hidden" name="voting_site_id" value="'.$thisVotesite['votesite_id'].'"/>';
				echo '<tr>';
					echo '<td class="text-center">'.$thisVotesite['votesite_title'].'</td>';
					echo '<td class="text-center">'.$thisVotesite['votesite_reward'].'</td>';
					echo '<td class="text-right"><button name="submit" value="submit" class="btn btn-primary">'.lang('vfc_txt_3',true).'</button></td>';
				echo '</tr>';
			echo '</form>';
		}
	}
	echo '</tbody>';
echo '</table>';