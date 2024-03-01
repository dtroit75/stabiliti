<?php include 'head.php'?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PWD | Members</title>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="./css1/tables.css">
<script>
$(document).ready(function(){
	// Activate tooltip
	$('[data-toggle="tooltip"]').tooltip();
	
	// Select/Deselect checkboxes
	var checkbox = $('table tbody input[type="checkbox"]');
	$("#selectAll").click(function(){
		if(this.checked){
			checkbox.each(function(){
				this.checked = true;                        
			});
		} else{
			checkbox.each(function(){
				this.checked = false;                        
			});
		} 
	});
	checkbox.click(function(){
		if(!this.checked){
			$("#selectAll").prop("checked", false);
		}
	});
});
</script>
<?php include 'header.php'?>


    <div class="container">

    	 <!-- Show success message if set -->
    <?php if (!empty($successMessage)) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

		<div class="table-responsive">
			<?php include 'menu.php'?>
			<div class="table-wrapper">
				<div class="table-title">
					<div class="row">
						<div class="col-xs-6">
							<h2>View <b>Members</b></h2>
						</div>
						<div class="col-xs-6">

							<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET"> <!-- Replace 'search.php' with your search handling file -->
							  <div class="input-group">
							    <input type="text" class="form-control" placeholder="Search BY Name" name="query">
							    <div class="input-group-append">
							      <button class="btn btn-primary" type="submit">
							        <i class="material-icons">search</i>
							      </button>
							    </div>
							  </div>
							</form>
						</div>
					</div>
				
						
					</div>

				<h4><?php
				if (isset($_GET['query'])) {
				    // Your database connection code here

				    $searchQuery = $_GET['query'];
				    // Modify this query as per your database structure
				    $sql = "SELECT * FROM user_list WHERE fullname LIKE '%$searchQuery%'";
				    $result = $conn->query($sql);

				    if ($result->num_rows > 0) {
				        while ($row = $result->fetch_assoc()) {
				            // Output the results
				            echo "Results:" . $row['fullname'] . "<br>";
				            // Output other columns as needed
				        }
				    } else {
				        echo "No results found";
				    }

				    // Close your database connection here
				}
				?></h4>
				</div>

				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								<span class="custom-checkbox">
									<input type="checkbox" id="selectAll">
									<label for="selectAll"></label>
								</span>
							</th>
							<th>No</th>
							<th>Full Name</th>
							<th>Mobile No</th>
							<th>ID No</th>
							<th>NCPWD No</th>
							<th>Disability Status</th>
							<th>Field</th>
							<th>Employment Status</th>
							<th>Education Level</th>
							
						</tr>
					</thead>
					<tbody> <?php

						// Pagination settings
							$recordsPerPage = 5; // Number of records per page
							$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1

							// Fetch total number of records
							$sqlTotal = "SELECT COUNT(user_id) AS total FROM user_list"; // Assuming 'id' is the primary key
							$resultTotal = $conn->query($sqlTotal);
							$rowTotal = $resultTotal->fetch_assoc();
							$totalRecords = $rowTotal['total'];

							// Calculate pagination variables
							$offset = ($page - 1) * $recordsPerPage;
							$totalPages = ceil($totalRecords / $recordsPerPage);


						    // Fetch staffs data from the database
						     $sql = "SELECT * FROM user_list LIMIT $offset, $recordsPerPage";
						    $result = $conn->query($sql);

						    if ($result->num_rows > 0) {
						    	 $count = 1;
						        while($row = $result->fetch_assoc()) {
						    ?>
						            <tr>
						                <td>
						                   <td><?php echo $count; ?></td> <!-- Display the count -->
						                </td>
						                <td><?php echo $row["fullname"]; ?></td>
						                <td><?php echo $row["mobile"]; ?></td>
						                <td><?php echo $row["id_no"]; ?></td>
						                 <td><?php echo $row["ncpwd_no"]; ?></td>
						                <td>
										    <?php
										   
										    if ($row["disability"] == 0) {
										        echo "Physically Disabled";
										    } else {
										        echo "Mentally Disabled";
										    }
										    ?>
										</td>
						                <td><?php echo $row["field"]; ?></td>
						                 <td><?php echo $row["employment"]; ?></td>
						                <td><?php echo $row["education"]; ?></td>

						            </tr>
						    <?php
						    	$count++; // Increment count for the next row
						        }
						    } else {
						        echo "<tr><td colspan='6'>No records found</td></tr>";
						    }
						    ?>
					
					</tbody>
				</table>
				<div class="clearfix"><?php
					echo '<div class="hint-text">Showing <b>' . min(($page - 1) * $recordsPerPage + $result->num_rows, $totalRecords) . '</b> out of <b>' . $totalRecords . '</b> entries</div>';

					// Display pagination links
					echo '<ul class="pagination">';
					if ($page > 1) {
					    echo '<li class="page-item"><a href="?page=1" class="page-link">First</a></li>';
					    echo '<li class="page-item"><a href="?page=' . ($page - 1) . '" class="page-link">Previous</a></li>';
					}
					for ($i = 1; $i <= $totalPages; $i++) {
					    echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a href="?page=' . $i . '" class="page-link">' . $i . '</a></li>';
					}
					if ($page < $totalPages) {
					    echo '<li class="page-item"><a href="?page=' . ($page + 1) . '" class="page-link">Next</a></li>';
					    echo '<li class="page-item"><a href="?page=' . $totalPages . '" class="page-link">Last</a></li>';
					}
					echo '</ul>'; ?>
				</div>
			</div>
		</div>        
    </div>

   <?php include 'footer.php'?>