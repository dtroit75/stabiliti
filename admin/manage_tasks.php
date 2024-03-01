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
							<h2>Manage <b>Tasks</b></h2>
						</div>
						<div class="col-xs-6">
							<a href="#addTaskModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Task</span></a>
							<a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>						
						</div>
					</div>
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
							<th>Task ID</th>
							<th>Date Created</th>
							<th>Description</th>
							<th>Eligibility</th>
							<th>Field</th>
							<th>Reward($)</th>
							<th>Expiry</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody> <?php

						// Pagination settings
							$recordsPerPage = 5; // Number of records per page
							$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1

							// Fetch total number of records
							$sqlTotal = "SELECT COUNT(report_id) AS total FROM tasks"; // Assuming 'id' is the primary key
							$resultTotal = $conn->query($sqlTotal);
							$rowTotal = $resultTotal->fetch_assoc();
							$totalRecords = $rowTotal['total'];

							// Calculate pagination variables
							$offset = ($page - 1) * $recordsPerPage;
							$totalPages = ceil($totalRecords / $recordsPerPage);


						    // Fetch staffs data from the database
						     $sql = "SELECT * FROM tasks LIMIT $offset, $recordsPerPage";
						    $result = $conn->query($sql);

						    if ($result->num_rows > 0) {
						    	 $count = 1;
						        while($row = $result->fetch_assoc()) {
						    ?>
						            <tr>
						                <td>
						                   <td><?php echo $count; ?></td> <!-- Display the count -->
						                </td>
						                <td><?php echo $row["taskID"]; ?></td>
						                <td><?php echo $row["date_created"]; ?></td>
						                <td><?php echo $row["description"]; ?></td>
						                <td>
										    <?php
										   
										    if ($row["disability"] == 0) {
										        echo "Physically Disabled";
										    } else {
										        echo "Intellectual Disabled";
										    }
										    ?>
										</td>
						                <td><?php echo $row["field"]; ?></td>
						                <td><?php echo $row["Reward"]; ?></td>
						                <td><?php echo $row["expiry"]; ?></td>
						                
						                
						                <td>
						                    <a href="#editTaskModal<?php echo $row["report_id"]; ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
						                    <a href="#deletetaskModal<?php echo $row["report_id"]; ?>" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
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
            <form action="tasks.php" method="post">
                <div class="modal-header">						
                    <h4 class="modal-title">Add New Task</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <!-- Task ID -->
                    <div class="form-group">
                        <label>Task ID</label>
                        <input type="text" name="task_id" class="form-control" required>
                    </div>
                    <!-- Date Created as Timestamp -->
                    <div class="form-group">
                        <label>Expiry Date</label>
                        <input type="date" name="expiry" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS" required>
                    </div>
                    <!-- Description -->
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <!-- Eligibility (Disability) -->
                    <div class="form-group">
                        <label>Eligibility (Disability)</label>
                        <select name="eligibility" class="form-control" required>
                            <option value="0">Physically Disabled</option>
                            <option value="1">Mentally Disabled</option>
                        </select>
                    </div>
                    <!-- Reward (Amount) -->
                    <div class="form-group">
                        <label>Reward ($)</label>
                        <input type="number" name="reward" class="form-control" required>
                    </div>
                    <!-- Field (Options: Teaching, etc.) -->
                    <div class="form-group">
                        <label>Field</label>
                        <select name="field" class="form-control" required>
                            	<option value="Teaching">Teaching</option>
						        <option value="Software Development">Software Development</option>
						        <option value="Customer Service">Customer Service</option>
						        <option value="Graphic Design">Graphic Design</option>
						        <option value="Data Entry">Data Entry</option>
						        <option value="Event Planning">Event Planning</option>
                               
                            <!-- Add more options if needed -->
                        </select>
                    </div>
                    <!-- Add more fields as needed -->

                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" name="add_task" class="btn btn-success" value="Add">
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
    <div id="editTaskModal<?php echo $row["report_id"]; ?>" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="tasks.php" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Task</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!-- Populate form fields with task details -->
                        <input type="hidden" name="task_id" value="<?php echo $row["report_id"]; ?>">
                        <div class="form-group">
                            <label>Expiry Date</label>
                            <input type="date" name="expiry" value="<?php echo $row["expiry"]; ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" required><?php echo $row["description"]; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Eligibility (Disability)</label>
                            <select name="eligibility" class="form-control" required>
                                <option value="0" <?php echo ($row["disability"] == 'Physically Disabled') ? 'selected' : ''; ?>>Physically Disabled</option>
                                <option value="1" <?php echo ($row["disability"] == 'Mentally Disabled') ? 'selected' : ''; ?>>Mentally Disabled</option>
                                <!-- Add more options if needed -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Reward ($)</label>
                            <input type="number" name="reward" value="<?php echo $row["Reward"]; ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
						    <label>Field</label>
						    <select name="field" class="form-control" required>
						        <option value="Teaching" <?php echo ($row["field"] == 'Teaching') ? 'selected' : ''; ?>>Teaching</option>
						        <option value="Software Development" <?php echo ($row["field"] == 'Software Development') ? 'selected' : ''; ?>>Software Development</option>
						        <option value="Customer Service" <?php echo ($row["field"] == 'Customer Service') ? 'selected' : ''; ?>>Customer Service</option>
						        <option value="Graphic Design" <?php echo ($row["field"] == 'Graphic Design') ? 'selected' : ''; ?>>Graphic Design</option>
						        <option value="Data Entry" <?php echo ($row["field"] == 'Data Entry') ? 'selected' : ''; ?>>Data Entry</option>
						        <option value="Event Planning" <?php echo ($row["field"] == 'Event Planning') ? 'selected' : ''; ?>>Event Planning</option>
						        <!-- Add more options if needed -->
						    </select>
						</div>
                        <!-- Add more fields as needed -->
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-info" name="edit_task" value="Save">
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
    <div id="deletetaskModal<?php echo $row["report_id"]; ?>" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="tasks.php" method="post">
                    <div class="modal-header">						
                        <h4 class="modal-title">Cancel Task</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="task_id" value="<?php echo $row["report_id"]; ?>">
                        <p>Are you sure you want to delete this record?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-danger" name="delete_task" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>
   <?php include 'footer.php'?>