<?php
	//Initial Setup
	//TODO: find the adventure.sql file and load it into your database using phpMyAdmin
	//TODO: set your database connection credentials in the config.php file
	require_once "../config.php";
	
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	if ($mysqli->connect_errno) {
		print($mysqli->connect_error);
		die();
	}


	// TODO: Instead of zero, get the labelno that ajax.js sent and sanitize as an int
	
	
	$labelno = filter_input(INPUT_POST,'labelno', FILTER_SANITIZE_NUMBER_INT);
	if(empty($labelno)){
		$labelno = 0;
	}

	// negative labelno has no meaning
	if ($labelno < 0) {
		echo 'Invalid labelno.';
		die();
	}
	

	// TODO: create and execute a sql query to select the appropriate 
	//       adventure record based on labelno
	$query = "SELECT * FROM adventure WHERE label = " .$labelno. ";";
	
	$result = $mysqli->query($query);

	if (!$result) {
		echo 'Query error';
		die();
	}

	$list = $result->fetch_assoc();

	header('Content-Type: application/json');
	echo json_encode(array(
		'dataindex' => $labelno,
		'storyline' => $list['story-line'],
		// TODO: Select the following fields from the database that 
		//       correspond to that labelNo.
		// TODO: package the json to give to the ajax.js

		'location' => $list['location'],
		'choice1' => $list['choice1-button'],
		'choice1_d' => $list['choice1-plot'],
		'choice2' => $list['choice2-button'],
		'choice2_d' => $list['choice2-plot'],
		'choice1_r' => $list['choice1-result'],
		'choice2_r' => $list['choice2-result'],
		'location_label' => $list['location-label']
	));

	
	
?>