<?php include_once 'includes/header.php' ?>
<?php include 'createCouchDBdatabase.php' ?>
<?php include 'displayCouchDBdatabases.php' ?>
<?php include 'deleteCouchDBdatabase.php' ?>

<?php
	if(isset($_GET['message']) && $_GET['message'] == "createDatabaseSuccess") {
		echo '<script language="javascript">';
		echo 'alert("Your database has been created in CouchDB successfully.")';
		echo '</script>';
	}
	else if(isset($_GET['message']) && $_GET['message'] == "deleteDatabaseSuccess") {
		echo '<script language="javascript">';
		echo 'alert("Your database has been deleted in CouchDB successfully.")';
		echo '</script>';
	}
?>

<section class="jumbotron jumbotron-fluid bg-light">
  <div class="container">
    <h6 class="display-4 text-center">Demo of CRUD operations for CouchDB</h6>
    <p class="lead">Learning Outcome: To understand the basic CRUD operations of CouchDB and visualize how these operations are carried out on a document database like CouchDB</p>   
    <P class="lead">Exercises in this Demo</p>
    <ul>
    	<li>Retrieve all the databases in CouchDB</li>
		<li>Create and insert a database into CouchDB</li>
		<li>Delete a database in CouchDB</li>
		<li>Retrieve all the personal particulars documents in CouchDB</li>
		<li>Create and insert a personal particulars document into CouchDB</li>
		<li>Update a personal particulars document in CouchDB</li>
		<li>Delete a personal particulars document in CouchDB</li>		
    </ul>
    <P class="lead">Learn CouchDB HTTP API with Swagger</p>
    <p>Go to your file directory and open this webpage (with Mozilla or IE) to learn more: <b><?php echo realpath('swagger-ui-master/dist/index.html')?></b></p>
  </div>
</section>

<section class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="section-header text-center">
				<h2>Databases in CouchDB</h2>
			</div>	
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			 <span class="anchor" id="formLogin"></span>
			 		<p>API: PUT localhost:5984/{dbname}</p>
                    <!-- form card login -->
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="mb-0" style="text-align:center">Create Database</h3>
                        </div>
                        <div class="card-body">
                            <form class="create-db-form" role="form" autocomplete="off" action="createCouchDBdatabase.php" method="POST">
                                <div class="form-group">
                                    <label>Database Name</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="dbname" value="<?php echo (isset($_POST['dbname']) ? $_POST['dbname']:''); ?>" required>
                                    <span class="text-danger"><?php echo $dbnameError ?></span>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg float-right">Create</button>
                            </form>
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->
		</div>
		<div class="col-md-8">
			<p>Retrieve All Databases API: GET localhost:5984/_all_dbs</p>
			<p>Delete Database API: DELETE localhost:5984/{dbname}</p>
			<table id="databaseRecords" class="table table-bordered">
			  <thead class="table-active">
			    <tr>
			      <th scope="col">No.</th>
			      <th scope="col">Database Name</th>
			      <th scope="col">Select</th>
			      <th scope="col">Delete</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php
			  		for($i=0; $i < count($json); $i++) {
			  			echo '<tr><th scope="row">'.($i+1).'</th>';
						echo '<td>'.$json[$i].'</td>';
						if(($json[$i] == "_global_changes") or ($json[$i] == "_replicator") or ($json[$i] == "_users")) {
							echo '<td>System generated Database</td><td>System generated Database</td></tr>';
						}
						else {
							$page = "documents.php?database=".$json[$i];
							echo '<td><button type="button" class="btn btn-secondary">Select</button></td><td><form class="delete-db-form" role="form" autocomplete="off" method="POST" action="index.php"><input type="hidden" name="deleteDatabaseInTable" value='.$json[$i].'><button type="submit" class="btn btn-secondary">Delete</button></form></td></tr>';
						}		
					}	
			  	?>
			  </tbody>
			</table>
			<label>Selected Database:</label>
			<input id="selectedDatabase" readonly>
			<button onclick="redirect()">Go!</button>
		</div>
	</div>
</section>

<br>
<br>



<?php include_once 'includes/footer_main.php' ?>

<script>
	var table = document.getElementById('databaseRecords'),rowIndex;
    for (var i = 1; i < table.rows.length; i++){
        table.rows[i].onclick = function(){
            rowIndex = this.rowsIndex;
        for (var i = 0, len = document.getElementsByTagName("input").length; i < len; i++) {
          document.getElementsByTagName("input")[i].checked = false; 
        }
            document.getElementById("selectedDatabase").value = this.cells[1].innerHTML; 
        };
    }
   

    function redirect()
    {
    	document.location.href = "documents.php?database=" + document.getElementById("selectedDatabase").value;
    //window.location(url);
    }
</script>