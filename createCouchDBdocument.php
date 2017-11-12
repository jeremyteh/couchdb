<?php include_once 'CouchDBusernamepassword.php';

// declare variables to get the value from input
$nricError =  $nameError =  $mobileNumError = $selectDatabaseError = "";

// set a boolean variable to check if the fields have errors and retrun true if no error was detected
$valid = True;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //=====================  nric validation ==========================
    // if the nric name field is empty
	if (empty($_POST["nric"])){
		$nricError  = "Please enter your nric.";
		$_POST["nric"] = "";
		$valid = False;
	}
    // else if the nric name field contains numbers
	else if (strlen($_POST["nric"]) != 9){ 
		$nricError  = "Please enter according to the format.";
		$_POST["nric"] = "";
		$valid = False;
	}

	//=====================  name validation ==========================
    // if the name name field is empty
	if (empty($_POST["name"])){
		$nameError  = "Please enter your name.";
		$_POST["name"] = "";
		$valid = False;
	}
    // else if the name name field contains numbers
	else if (!ctype_alpha($_POST["name"])){ 
		$nameError  = "Please enter letters only.";
		$_POST["name"] = "";
		$valid = False;
	}

	//=====================  nmobile number validation ==========================
    // if the mobile number name field is empty
	if (empty($_POST["mobileNum"])){
		$mobileNumError  = "Please enter your mobile number";
		$_POST["mobileNum"] = "";
		$valid = False;
	}
	// else if the mobile number name field contains aplhabets
	else if (ctype_alpha($_POST["mobileNum"])){ 
		$nameError  = "Please enter numbers only.";
		$_POST["mobileNum"] = "";
		$valid = False;
	}	
    // else if the mobile number name field contains numbers less than 8
	else if (strlen($_POST["mobileNum"]) != 8){ 
		$mobileNumError  = "Please enter 8 digits.";
		$_POST["mobileNum"] = "";
		$valid = False;
	}

	//=====================  database selected validation ==========================
    // if no database is selected
     // if the mobile number name field is empty
	if (empty($_POST["databaseSelected"])){
		$selectDatabaseError  = "You have not selected any database.";
		$valid = False;
	}
	
	// if there are no errors in the create database form, it will proceed to insert the database
	if($valid = True) {

		$ch = curl_init();

		$personDetails = array(
			'nric' => $_POST["nric"],
			'name' => $_POST["name"],
			'mobileNum' => $_POST["mobileNum"]
		);

		$person = json_encode($personDetails);

		curl_setopt($ch, CURLOPT_URL, 'http://localhost:5984/'.$_POST["databaseSelected"]. '/' .$personDetails['nric']);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $person);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-type: application/json',
		    'Accept: /',
		 ));

		curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);

		$response = curl_exec($ch);
		echo $response;

		curl_close($ch);

		header("Location: documents.php?message=createDocumentSuccess&database=".$_POST["databaseSelected"]);
	}
}
?>