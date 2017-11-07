<?php include_once 'CouchDBusernamepassword.php';

$ch = curl_init(); 

curl_setopt($ch, CURLOPT_URL, 'http://localhost:5984/_all_dbs');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'Content-type: application/json',
	'Accept: /',
));

curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);

$response = curl_exec($ch);
curl_close($ch);

$json = json_decode($response);

?>