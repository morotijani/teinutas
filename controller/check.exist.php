<?php 
	require_once ("../db_connection/conn.php");

	// check if email exist or not
	if (isset($_POST['email'])) {
		$email = sanitize($_POST['email']);

		$query = "
            SELECT * FROM tein_membership 
            WHERE membership_email = ?
        ";
        $statement = $conn->prepare($query);
        $statement->execute([$email]);
        if ($statement->rowCount() > 0) {
            echo 'Email already exist.';
        } else {
        	echo '';
        }
	} else {
		// check if student id exist
		if (isset($_POST['studentId'])) {
			$studentid = sanitize($_POST['studentId']);

			$query = "
	            SELECT * FROM tein_membership 
	            WHERE membership_student_id = ?
	        ";
	        $statement = $conn->prepare($query);
	        $statement->execute([$studentid]);
	        if ($statement->rowCount() > 0) {
	            echo 'Student ID already exist.';
	        } else {
	        	echo '';
	        }
	    }
	
		if (isset($_POST['member_id'])) {
			$member_id = sanitize($_POST['member_id']);

	        $level = '';
	        $email = '';
	        $cout = [];

			$query = "
	            SELECT *, tein_membership.id AS tein_membership_id FROM tein_membership 
	            INNER JOIN tein_dues 
	            ON tein_dues.member_id = tein_membership.id
	            WHERE tein_membership.membership_identity = ? 
	            LIMIT 1
	        ";
	        $statement = $conn->prepare($query);
	        $statement->execute([$member_id]);
	        $row = $statement->fetchAll();
	        $row_count = $statement->rowCount();

	       if ($row_count > 0) {
	            $member_id = $row[0]['tein_membership_id'];
	            $level = $row[0]['membership_level'];
	            $email = $row[0]['membership_email'];

		        $cout['msg'] = '200';
	            if ($level == 'L100') {
	            	if ($row[0]['level_100'] != null) {
	            		$lvl = 'L200';
	            	}

	            	if ($row[0]['level_200'] != null) {
	            		$lvl = 'L300';
	            	}

	            	if ($row[0]['level_300'] != null) {
	            		$lvl = 'L400';
	            	}
	            } elseif ($level == 'L200') {
	            	if ($row[0]['level_200'] != null) {
	            		$lvl = 'L300';
	            	}

	            	if ($row[0]['level_300'] != null) {
	            		$lvl = 'L400';
	            	}
	            } elseif ($level == 'L300') {
	            	if ($row[0]['level_300'] != null) {
	            		$lvl = 'L400';
	            	}
	            }

	            if ($row[0]['level_400'] != null) {
	            	$cout['msg'] = 'done';
	            }

		        $cout['mid'] = $member_id;
		        $cout['email'] = $email;
		        $cout['level'] = $lvl;
	        	
	       } else {
		    	$cout['msg'] = '';
	      	}
	        $cout = json_encode($cout);
	        echo $cout;
		}
	}



