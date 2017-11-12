<?php include_once 'CouchDBusernamepassword.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//if($_POST['update']) {

	$ch = curl_init();

	$personDetails = array(
		'nric' => $_POST["updatenric"],
		'name' => $_POST["updateName"],
		'mobileNum' => $_POST["updatemobileNum"]
	);

	$personDetails['_rev'] = $_POST["rev"];

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

	header("Location: documents.php?message=editDocumentSuccess&database=".$_POST["databaseSelected"]);
	 
 }

?>