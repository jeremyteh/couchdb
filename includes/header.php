<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="img/favicon.ico" />
		<title>CouchDB Learning Portal</title>
		
		<!-- CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<!-- <link rel="stylesheet" href="css/animate.css">
		
		<link rel="stylesheet" href="css/responsive.css"> -->

		<script src="https://oss.maxcdn.com/html5shiv/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	</head>

	<body>

		<header>
			<nav class="navbar navbar-light navbar-expand-md bg-light justify-content-center">
				<img src="img/navbar-icon.png" alt="logo">
            	<a href="index.php" class="navbar-brand d-flex w-50 mr-auto">CouchDB Learning Portal</a>
            	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar3">
                <span class="navbar-toggler-icon"></span>
	            </button>
	            <div class="navbar-collapse collapse" id="collapsingNavbar3">
	                <ul class="nav navbar-nav ml-auto w-100 justify-content-end">               	
	                    <a class="btn btn-outline-dark my-2 my-sm-0" href="http://docs.couchdb.org/en/2.1.0/http-api.html#">CouchDB Documentation</a>
	                </ul>
	            </div>
        	</nav>
    	</header>