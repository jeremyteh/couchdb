<?php include_once 'CouchDBusernamepassword.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$ch = curl_init(); 

	$database = $_POST['deleteDatabaseInTable'];
	$documentID = $_POST['deleteNRICInTable'];
	$_rev = $_POST['deleteRevInTable'];

	 curl_setopt($ch, CURLOPT_URL, sprintf('http://localhost:5984/%s/%s/?rev=%s', $database, $documentID, $_rev));
	 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Content-type: application/json',
	    'Accept: /',
	 ));

	 curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);

	 $response = curl_exec($ch);
	 curl_close($ch);
	 
	header("Location: documents.php?message=deleteDocumentSuccess&database=".$database);
	 
 }

?>