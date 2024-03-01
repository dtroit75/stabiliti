<?php include 'head.php'?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff|PWD</title>

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
							<h2>Manage <b>Funds</b></h2>
						</div><br>
						<div class="col-xs-6">
							<a href="#addTaskModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Register New Fund</span></a>
						
						</div>

						<div class="col-xs-6">

							<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET"> <!-- Replace 'search.php' with your search handling file -->
							  <div class="input-group">
							    <input type="text" class="form-control" placeholder="Search BY Category" name="query">
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

				<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])) {
    // Retrieve the search term from the form
    $search = $_GET['query'];

    // Prepare SQL statement to search for funds by any field
    $sql = "SELECT * FROM funds WHERE 
            sponsor LIKE CONCAT('%', ?, '%') OR 
            description LIKE CONCAT('%', ?, '%') OR
            category LIKE CONCAT('%', ?, '%') OR
            payment_method LIKE CONCAT('%', ?, '%')"; // Add more columns as needed

    // Create a prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("ssss", $search, $search, $search, $search); // Adjust parameter count based on columns

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Get the result
            $result = $stmt->get_result();

            // Display the results
            while ($row = $result->fetch_assoc()) {
                // Output each row's data as needed
                echo "Fund ID: " . $row["id"] . "<br>";
                echo "Sponsor: " . $row["sponsor"] . "<br>";
                echo "Description: " . $row["description"] . "<br>";
                // Add more fields as needed
                echo "<hr>";
            }

            // Free the result set
            $result->free_result();
        } else {
            // Display an error message if the execution fails
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }

  
}

?>
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
							<th>Sponsor</th>
							<th>Payment Description</th>
							<th>Category</th>
							<th>Amount (Ksh)</th>
							<th>Account</th>
							<th>Actions</th>

							
						</tr>
					</thead>
					<tbody> <?php

						// Pagination settings
							$recordsPerPage = 5; // Number of records per page
							$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1

							// Fetch total number of records
							$sqlTotal = "SELECT COUNT(id) AS total FROM funds"; // Assuming 'id' is the primary key
							$resultTotal = $conn->query($sqlTotal);
							$rowTotal = $resultTotal->fetch_assoc();
							$totalRecords = $rowTotal['total'];

							// Calculate pagination variables
							$offset = ($page - 1) * $recordsPerPage;
							$totalPages = ceil($totalRecords / $recordsPerPage);


						    // Fetch staffs data from the database
						     $sql = "SELECT * FROM funds LIMIT $offset, $recordsPerPage";
						    $result = $conn->query($sql);

						    if ($result->num_rows > 0) {
						    	 $count = 1;
						        while($row = $result->fetch_assoc()) {
						    ?>
						            <tr>
						                <td>
						                   <td><?php echo $count; ?></td> <!-- Display the count -->
						                </td>
						                <td><?php echo $row["sponsor"]; ?></td>
						                <td><?php echo $row["description"]; ?></td>
						                <td>
										    <?php
										   
										    if ($row["category"] == 0) {
										        echo "Physically Disabled";
										    } else {
										        echo "Intellectual Disabled";
										    }
										    ?>
										</td>
						                <td><?php echo $row["amount"]; ?></td>
						                <td><?php echo $row["payment_method"]; ?></td>			                
						                <td>
						                    <a href="#editTaskModal<?php echo $row["id"]; ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
						                    <a href="#deletetaskModal<?php echo $row["id"]; ?>" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
						                </td>
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
	<!-- Edit Modal HTML -->
	<!-- Add Task Modal HTML -->
<div id="addTaskModal" class="modal fade">

    <div class="modal-dialog">
        <div class="modal-content">
            <form action="fund_func.php" method="post">
                <div class="modal-header">						
                    <h4 class="modal-title">Register New Fund</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <!-- Task ID -->
                    <div class="form-group">
                        <label>Sponsor</label>
                        <input type="text" name="sponsor" class="form-control" required>
                    </div>
                    
                    <!-- Description -->
                    <div class="form-group">
                        <label>Payment Description</label>
                        <select name="description" class="form-control" required>
                            	<option value="Weekly">Weekly</option>
						        <option value="Monthly">Monthly</option>
						        <option value="Annually">Annually</option>					                                  
                            <!-- Add more options if needed -->
                        </select>
                    </div>
                    <!-- Eligibility (Disability) -->
                    <div class="form-group">
                        <label>Eligibility (Disability)</label>
                        <select name="category" class="form-control" required>
                            <option value="0">Physically Disabled</option>
                            <option value="1">Mentally Disabled</option>
                        </select>
                    </div>
                    <!-- Reward (Amount) -->
                    <div class="form-group">
                        <label>Amount (Ksh)</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <!-- Field (Options: Teaching, etc.) -->
                    <div class="form-group">
                        <label>Account</label>
                        <select name="payment_method" class="form-control" required>
                            	<option value="Mpesa">Mpesa</option>
						        <option value="KCB">KCB</option>
						        <option value="Family Bank">Family Bank</option>
						        <option value="Stanbic">Stanbic</option>
						        
                               
                            <!-- Add more options if needed -->
                        </select>
                    </div>
                    <!-- Add more fields as needed -->

                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" name="add_fund" class="btn btn-success" value="Add">
                </div>
            </form>
        </div>
    
</div>

</div>

<!-- Edit Modal HTML -->
<?php
// Loop through the task records again to create modals for each task
$result->data_seek(0); // Reset result pointer to start
while ($row = $result->fetch_assoc()) {
    ?>
    <!-- Edit Modal for each task -->
    <div id="editTaskModal<?php echo $row["id"]; ?>" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="fund_func.php" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">UPDATE FUND</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!-- Populate form fields with task details -->
                        <input type="hidden" name="fund_id" value="<?php echo $row["id"]; ?>">

                         <div class="form-group">
                            <label>Sponsor</label>
                            <textarea name="sponsor" class="form-control" required><?php echo $row["sponsor"]; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Payment Description</label>
                            <select name="description" class="form-control" required>
						        <option value="Weekly" <?php echo ($row["description"] == 'Weekly') ? 'selected' : ''; ?>>Weekly</option>
						        <option value="Monthly" <?php echo ($row["description"] == 'Monthly') ? 'selected' : ''; ?>>Monthly</option>
						        <option value="Annually" <?php echo ($row["description"] == 'Annually') ? 'selected' : ''; ?>>Annually</option>
						       
						    </select>
                        </div>
                        <div class="form-group">
                            <label>Eligibility (Disability)</label>
                            <select name="category" class="form-control" required>
                                <option value="0" <?php echo ($row["category"] == 'Physically Disabled') ? 'selected' : ''; ?>>Physically Disabled</option>
                                <option value="1" <?php echo ($row["category"] == 'Mentally Disabled') ? 'selected' : ''; ?>>Mentally Disabled</option>
                                <!-- Add more options if needed -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Amount (Ksh)</label>
                            <input type="number" name="amount" value="<?php echo $row["amount"]; ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
						    <label>Account</label>
						    <select name="payment_method" class="form-control" required>
						        <option value="Mpesa" <?php echo ($row["payment_method"] == 'Mpesa') ? 'selected' : ''; ?>>Mpesa</option>
						        <option value="KCB" <?php echo ($row["payment_method"] == 'KCB') ? 'selected' : ''; ?>>KCB</option>
						        <option value="Family Bank" <?php echo ($row["payment_method"] == 'Family Bank') ? 'selected' : ''; ?>>Family Bank</option>
						        <option value="Stanbic" <?php echo ($row["payment_method"] == 'Stanbic') ? 'selected' : ''; ?>>Stanbic</option>
						        
						        <!-- Add more options if needed -->
						    </select>
						</div>
                        <!-- Add more fields as needed -->
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-info" name="edit_fund" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
?>
	<!-- Delete Modal HTML -->
	<?php
$result->data_seek(0); // Reset result pointer to start
while($row = $result->fetch_assoc()) {
    ?>
    <!-- Delete Modal for each staff member -->
    <div id="deletetaskModal<?php echo $row["id"]; ?>" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="fund_func.php" method="post">
                    <div class="modal-header">						
                        <h4 class="modal-title">Cancel Fund</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="fund_id" value="<?php echo $row["id"]; ?>">
                        <p>Are you sure you want to delete this record?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-danger" name="delete_fund" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>



   <?php include 'footer.php'?>