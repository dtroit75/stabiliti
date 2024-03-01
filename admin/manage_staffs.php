<?php include 'head.php'?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin|Staff</title>

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
							<h2>Manage <b>Employees</b></h2>
						</div>
						<div class="col-xs-6">
							<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
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
							<th>ID</th>
							<th>Full Name</th>
							<th>Email</th>
							<th>Username</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody> <?php

						// Pagination settings
							$recordsPerPage = 5; // Number of records per page
							$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1

							// Fetch total number of records
							$sqlTotal = "SELECT COUNT(id) AS total FROM staffs"; // Assuming 'id' is the primary key
							$resultTotal = $conn->query($sqlTotal);
							$rowTotal = $resultTotal->fetch_assoc();
							$totalRecords = $rowTotal['total'];

							// Calculate pagination variables
							$offset = ($page - 1) * $recordsPerPage;
							$totalPages = ceil($totalRecords / $recordsPerPage);


						    // Fetch staffs data from the database
						     $sql = "SELECT id, fullname, email, username FROM staffs LIMIT $offset, $recordsPerPage";
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
						                <td><?php echo $row["email"]; ?></td>
						                <td><?php echo $row["username"]; ?></td>
						                
						                <td>
						                    <a href="#editEmployeeModal<?php echo $row["id"]; ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
						                    <a href="#deleteEmployeeModal<?php echo $row["id"]; ?>" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
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
	<div id="addEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="staff.php" method="post">
					<div class="modal-header">						
						<h4 class="modal-title">Add Staff</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
							<label>Full Name</label>
							<input type="text" name="fullname" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" class="form-control" required>
						</div>
						<div class="form-group">
							<label>username</label>
							<input type="text" name="username" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="text" name="password" class="form-control" required>
						</div>					
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" name="submit"class="btn btn-success" value="Add">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Edit Modal HTML -->
	<?php
// Loop through the staff records again to create modals for each staff member
$result->data_seek(0); // Reset result pointer to start
while($row = $result->fetch_assoc()) {
    ?>
    <!-- Edit Modal for each staff member -->
    <div id="editEmployeeModal<?php echo $row["id"]; ?>" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="staff.php" method="post">
                    <div class="modal-header">						
                        <h4 class="modal-title">Edit Staff</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!-- Populate form fields with staff details -->
                        <input type="hidden" name="staff_id" value="<?php echo $row["id"]; ?>">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="fullname" value="<?php echo $row["fullname"]; ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?php echo $row["email"]; ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" value="<?php echo $row["username"]; ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-info" name="edit_staff" value="Save">
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
    <div id="deleteEmployeeModal<?php echo $row["report_id"]; ?>" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="staff.php" method="post">
                    <div class="modal-header">						
                        <h4 class="modal-title">Delete Staff</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="staff_id" value="<?php echo $row["id"]; ?>">
                        <p>Are you sure you want to delete this record?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-danger" name="delete_staff" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>
   <?php include 'footer.php'?>