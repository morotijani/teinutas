<?php 

	// Upload Post Image And Save To Draft 

	require_once ('../../db_connection/conn.php');

	if ($_FILES["news_media"]["name"]  != '') {

		$test = explode(".", $_FILES["news_media"]["name"]);

		$extention = end($test);

		$name = rand(100, 999) . '.' . $extention;

		$location = BASEURL . 'dist/media/temporary/' . $name;

		move_uploaded_file($_FILES["news_media"]["tmp_name"], $location);

		echo '
				<div id="removeTempuploadedFile">
					<a href="javascript:void(0)" id="'.$location.'" class="removeImg float-right text-danger font-weight-bolder" style="font-size: 12px;">
						remove
					</a>
					<br>
					<img src="' . PROOT . 'dist/media/temporary/'.$name.'" id="removeImage" class="img-thumbnail img-fluid" style="width: 200px; height: 200px;">
					<input type="hidden" name="uploaded_image" id="uploaded_image" value="'.$location.'">
				</div>';
	}

?>