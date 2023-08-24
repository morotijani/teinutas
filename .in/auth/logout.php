<?php 

	// USER SIGNOUT PAGE

    require_once ("../../db_connection/conn.php");

    unset($_SESSION['TNAdmin']);

    session_destroy();

	redirect(PROOT . '.in/auth/signin');
