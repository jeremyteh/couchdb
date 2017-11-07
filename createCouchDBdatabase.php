<?php include_once 'CouchDBusernamepassword.php';

// declare variables to get the value from input
$dbnameError = "";

// set a boolean variable to check if the fields have errors and retrun true if no error was detected
$valid = True;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //=====================  database name validation ==========================
    // if the database name field is empty
	if (empty($_POST["dbname"])){
		$dbnameError  = "Please enter a database name.";
		$_POST["dbname"] = "";
		$valid = False;
	}
    // else if the database name field contains numbers
	else if (!ctype_alpha($_POST["dbname"])){ 
		$dbnameError  = "Please enter letters only.";
		$_POST["dbname"] = "";
		$valid = False;
	}
	
	// if there are no errors in the create database form, it will proceed to insert the database
	if($valid = True) {
		$ch = curl_init(); 

		curl_setopt($ch, CURLOPT_URL, 'http://localhost:5984/' .$_POST["dbname"]);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-type: application/json',
			'Accept: /',
		));

		curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);
		$response = curl_exec($ch);
		echo $response;
		curl_close($ch);
		header("Location: index.php?message=createDatabaseSuccess");
	}
}
?>