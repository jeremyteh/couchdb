<?php include_once 'CouchDBusernamepassword.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$ch = curl_init(); 

	curl_setopt($ch, CURLOPT_URL, 'http://localhost:5984/'.$_POST["deleteDatabaseInTable"]);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Content-type: application/json',
	    'Accept: /',
	));

	curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);

	$response = curl_exec($ch);
	echo $response;
	curl_close($ch);

	header("Location: index.php?message=deleteDatabaseSuccess");
}
?>