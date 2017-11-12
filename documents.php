<?php include_once 'includes/header.php' ?>
<?php include 'createCouchDBdocument.php' ?>
<?php include 'displayCouchDBdocuments.php' ?>
<?php include 'editCouchDBdocument.php' ?>
<?php include 'deleteCouchDBdocument.php' ?>

<?php
	if(isset($_GET['message']) && $_GET['message'] == "createDocumentSuccess") {
		echo '<script language="javascript">';
		echo 'alert("Your particulars has been inserted in a new document successfully.")';
		echo '</script>';
	}
	else if(isset($_GET['message']) && $_GET['message'] == "editDocumentSuccess") {
		echo '<script language="javascript">';
		echo 'alert("Your document has been updated successfully.")';
		echo '</script>';
	}
	else if(isset($_GET['message']) && $_GET['message'] == "deleteDocumentSuccess") {
		echo '<script language="javascript">';
		echo 'alert("Your document has been deleted successfully.")';
		echo '</script>';
	}
?>


<section class="jumbotron jumbotron-fluid bg-light">
  <div class="container">
    <h6 class="display-4 text-center">Demo of CRUD operations for CouchDB</h6>
    <p class="lead">Learning Outcome: To understand the basic CRUD operations of CouchDB and visualize how these operations are carried out on a document database like CouchDB</p>   
    <P class="lead">Exercises in this Demo</P>
    <ul>
    	<li>Retrieve all the databases in CouchDB</li>
		<li>Create and insert a database into CouchDB</li>
		<li>Delete a database in CouchDB</li>
		<li>Retrieve all the personal particulars documents in CouchDB</li>
		<li>Create and insert a personal particulars document into CouchDB</li>
		<li>Update a personal particulars document in CouchDB</li>
		<li>Delete a personal particulars document in CouchDB</li>
    </ul>     
  </div>
</section>

<section class="container">
	
	<div class="row">
		<div class="col-md-12">
			<div class="section-header text-center">
				<h2>Documents in Database in CouchDB</h2>
			</div>	
		</div>
	</div>
	
	<div class="row">
		<p> Retrieve All Documents API: GET localhost:5984/<?php echo $_GET['database'] ?>/_all_docs<p>
		<p> Delete Document API: DELETE localhost:5984/<?php echo $_GET['database'] ?>/{document_id}/{document_revision}}<p>
		<div class="col-md-12">
			<table id="documentRecords" class="table table-bordered">
				<thead class="table-active">
			    <tr>
			      <th scope="col">No.</th>
			      <th scope="col">Rev</th>
			      <th scope="col">NRIC</th>
			      <th scope="col">Name</th>
			      <th scope="col">Mobile Number</th>
			      <th scope="col">Update</th>
			      <th scope="col">Delete</th>
			    </tr>
			  </thead>
				<tbody>
			  	<?php 
				  	if(isset($_GET['database']) && $_GET['database'] != null) {
				  		if($json->{'total_rows'} != 0) {
							for($i=0; $i < $json->{'total_rows'}; $i++) {
								$ch = curl_init();
							    curl_setopt($ch, CURLOPT_URL, 'http://localhost:5984/'.$_GET['database'].'/' . $json->{"rows"}[$i]->{"id"});
							    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
							    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							       'Content-type: application/json',
							       'Accept: /'
							    ));

							    curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);

							    $newResponse = curl_exec($ch);
							    curl_close($ch);

							    $data = json_decode($newResponse);
							    echo '<tr><th scope="row">'.($i+1).'</th>';
							    echo '<td>'.$data->{"_rev"}.'</td>
							    <td>'.$data->{"nric"}.'</td>
							    <td>'.$data->{"name"}.'</td>
							    <td>'.$data->{"mobileNum"}.'</td>';
							    echo '<td><button type="button" class="btn btn-secondary">Update</button></td><td><form class="delete-document-form" role="form" autocomplete="off" method="POST" action="deleteCouchDBdocument.php" ><input type="hidden" name="deleteDatabaseInTable" value="'.$_GET['database'].'"><input type="hidden" name="deleteNRICInTable" value="'.$data->{"nric"}.'"><input type="hidden" name="deleteRevInTable" value="'.$data->{"_rev"}.'"><button type="submit" class="btn btn-secondary">Delete</button></form></td></tr>';
							}
						}
						else {
							echo '<tr><td>No documents in database.</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
						}
					}
					else {
						echo '<tr><td>No documents in database.</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
					}
				?>
			  </tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-4">
			 <span class="anchor" id="formLogin"></span>
			 		<p> API: PUT localhost:5984/<?php echo $_GET['database'] ?>/{document_id}<p>
                    <!-- form card login -->
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="mb-0" style="text-align:center">Create New Document</h3>
                        </div>
                        <div class="card-body">
                            <form class="create-document-form" role="form" autocomplete="off" action="createCouchDBdocument.php" method="POST">
                                <div class="form-group">
                                    <label>NRIC</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="nric" value="<?php echo (isset($_POST['nric']) ? $_POST['nric']:''); ?>" placeholder= "SXXXXXXXA" required>
                                    <span class="text-danger"><?php echo $nricError ?></span>
                                    <label>Name</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="name" value="<?php echo (isset($_POST['name']) ? $_POST['name']:''); ?>" required>
                                    <span class="text-danger"><?php echo $nameError ?></span>
                                    <label>Mobile Number</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="mobileNum" value="<?php echo (isset($_POST['mobileNum']) ? $_POST['mobileNum']:''); ?>" required>
                                    <span class="text-danger"><?php echo $mobileNumError ?></span>
                                    <input type="hidden" class="form-control form-control-lg rounded-0" name="databaseSelected" value="<?php echo $_GET['database']?>">
                                    <span class="text-danger"><?php echo $selectDatabaseError ?></span>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg float-right">Insert</button>
                            </form>
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->
		</div>
		
		<div class="col-md-4">
			 <span class="anchor" id="formLogin"></span>
			 		<p> API: PUT localhost:5984/<?php echo $_GET['database'] ?>/{document_id}<p>
                    <!-- form card login -->
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="mb-0" style="text-align:center">Update Document</h3>
                        </div>
                        <div class="card-body">
                            <form name="update" class="edit-document-form" role="form" autocomplete="off" action="editCouchDBdocument.php" method="POST">
                                <div class="form-group">
                                	<input type="hidden" id="toUpdateRev" name="rev">
                                    <label>NRIC</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" id="toUpdateNric" name="updatenric" value="<?php echo (isset($_POST['nric']) ? $_POST['nric']:''); ?>" readonly>
                                    <span class="text-danger"><?php echo $nricError ?></span>
                                    <label>Name</label>
                                     <input type="text" class="form-control form-control-lg rounded-0" id="toUpdateName" name="updateName" value="<?php echo (isset($_POST['name']) ? $_POST['name']:''); ?>" required>
                                    <span class="text-danger"><?php echo $nameError ?></span>
                                    <label>Mobile Number</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" id="toUpdateMobile" name="updatemobileNum" value="<?php echo (isset($_POST['mobileNum']) ? $_POST['mobileNum']:''); ?>" required>
                                    <span class="text-danger"><?php echo $mobileNumError ?></span>
                                    <input type="hidden" class="form-control form-control-lg rounded-0" name="databaseSelected" value="<?php echo $_GET['database']?>">
                                    <span class="text-danger"><?php echo $selectDatabaseError ?></span>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg float-right">Update</button>
                            </form>
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->
		</div>
		<div class="col-md-2"></div>
	</div>
</section>

<?php include_once 'includes/footer_main.php' ?>

<script>
    var tabla = document.getElementById('documentRecords'),rIndex;
        for (var i = 1; i < tabla.rows.length; i++){
            tabla.rows[i].onclick = function(){
                rIndex = this.rowsIndex;
        for (var i = 0, len = document.getElementsByTagName("input").length; i < len; i++) {
          document.getElementsByTagName("input")[i].checked = false; 
        }
                document.getElementById("toUpdateRev").value = this.cells[1].innerHTML;
                document.getElementById("toUpdateNric").value = this.cells[2].innerHTML;
                document.getElementById("toUpdateName").value = this.cells[3].innerHTML;
        		document.getElementById("toUpdateMobile").value = this.cells[4].innerHTML;
            };
        }
</script>