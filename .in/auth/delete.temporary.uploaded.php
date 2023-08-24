<?php 

	// Delete Temporary Uploaded img

	if (isset($_POST['tempuploded_file_id'])) {

		$tempuploded_img_id_filePath = $_POST['tempuploded_file_id'];

		unlink($tempuploded_img_id_filePath);
	}

?>