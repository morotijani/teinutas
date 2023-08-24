<?php
	require_once ("../db_connection/conn.php");

	if (isset($_POST['reference'])) {
		
		$reference = sanitize($_POST['reference']);
		$id = sanitize((int)$_POST['id']);
		$level = sanitize($_POST['level']);

		if (!empty($reference) || $reference != '') {
            $sql = 'UPDATE `tein_dues` SET ';
			if ($level == 'L100') {
                $sql .= "
                    `level_100` = ? 
                ";
            } elseif ($level == 'L200') {
                $sql .= "
                    `level_200` = ? 
                ";
            } elseif ($level == 'L300') {
                $sql .= "
                    `level_300` = ? 
                ";
            } elseif ($level == 'L400') {
                $sql .= "
                    `level_400` = ? 
                ";
            }
            $sql .= 'WHERE `member_id` = ?';
            $statement = $conn->prepare($sql);
            $result = $statement->execute([$reference, $id]);
            if (isset($result)) {
            	$_SESSION['member.paid'] = $reference;
            	echo '';
            }
		}
	}