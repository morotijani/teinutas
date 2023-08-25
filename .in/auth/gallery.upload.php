<?php

// upload.php
require_once ("../../db_connection/conn.php");

if (isset($_FILES['images'])) {
	for ($count = 0; $count < count($_FILES['images']['name']); $count++) {
		$extension = pathinfo($_FILES['images']['name'][$count], PATHINFO_EXTENSION);

		$new_name = uniqid() . '.' . $extension;
		$new_name = 'dist/media/gallery/' . $new_name;
		$location = BASEURL . $new_name;
		$dateAded = date('Y-m-d H:i:s A');
		$move = move_uploaded_file($_FILES['images']['tmp_name'][$count], $location);
		
		if ($move) {
			$query = "
				INSERT INTO tein_gallery (gallery_media, gallery_date_added) 
				VALUES (?, ?)
			";
			$statement = $conn->prepare($query);
			$result = $statement->execute([$new_name, $dateAded]);
		}

	}

	echo 'success';
}


?>