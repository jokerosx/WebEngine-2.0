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

try {
	
	// Edit news submit
	if(check($_POST['news_submit'])) {
		try {
			
			$NewsEdit = new News();
			$NewsEdit->setId($_POST['news_id']);
			$NewsEdit->setTitle($_POST['news_title']);
			$NewsEdit->setContent($_POST['news_content']);
			$NewsEdit->setAuthor($_POST['news_author']);
			
			$NewsEdit->editNews();
			message('success', 'News successfully edited!');
			
		} catch(Exception $ex) {
			message('error', $ex->getMessage());
		}
	}
	
	if(!check($_GET['id'])) throw new Exception('News id not provided.');
	
	$News = new News();
	$News->setId($_GET['id']);
	$newsData = $News->loadSingleNewsById();
	if(!is_array($newsData)) throw new Exception('News id is not valid.');
	
	echo '<div class="row">';
		echo '<div class="col-sm-12 col-md-10 col-lg-8">';
			echo '<div class="card">';
				echo '<div class="header">Edit News</div>';
				echo '<div class="content">';
					echo '<form role="form" method="post">';
						echo '<input type="hidden" name="news_id" value="'.$newsData['news_id'].'"/>';
						echo '<div class="form-group">';
							echo '<label>Title</label>';
							echo '<input type="text" name="news_title" class="form-control" value="'.$newsData['news_title'].'">';
						echo '</div>';
						echo '<div class="form-group">';
							echo '<label>Content</label>';
							echo '<textarea name="news_content" id="news_content">'.$newsData['news_content'].'</textarea>';
						echo '</div>';
						echo '<div class="form-group">';
							echo '<label>Author</label>';
							echo '<input type="text" name="news_author" value="'.$newsData['news_author'].'" class="form-control">';
						echo '</div>';
						echo '<button type="submit" class="btn btn-large btn-warning" name="news_submit" value="ok">Save Changes</button> ';
						echo '<a href="'.admincp_base('news/manager').'" class="btn btn-large btn-danger">Cancel</a>';
					echo '</form>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}