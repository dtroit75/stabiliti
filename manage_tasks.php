<?php include 'head.php'?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Member | PWD</title>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="./css1/tables.css">

</head>
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
<?php include 'menu.php'?>
    	 <!-- Show success message if set -->
    <?php if (!empty($successMessage)) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <?php


// Retrieve the user ID based on the email stored in the session
if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];

    // Query to fetch user ID based on email
    $sql = "SELECT user_id, disability FROM user_list WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user ID and store it in the session
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['disability'] = $row['disability'];
    } else {
        // Handle case where user ID isn't found for the email
        echo "User ID not found for the email: " . $user_email;
    }

    $stmt->close();
} else {
    // Handle case where email isn't stored in the session
    echo "Email not found in session.";
}
?>


		<div class="table-responsive">
			
			<div class="table-wrapper">
				<div class="table-title">
					<div class="row">
						<div class="col-xs-6">
							<h2>View <b>Tasks</b></h2>
						</div>
						<div class="col-xs-6">

							<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET"> <!-- Replace 'search.php' with your search handling file -->
							  <div class="input-group">
							    <input type="text" class="form-control" placeholder="Search BY ID" name="query">
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
				if (isset($_GET['query'])) {
				    // Your database connection code here

				    $searchQuery = $_GET['query'];
				    // Modify this query as per your database structure
				    $sql = "SELECT * FROM tasks WHERE taskID LIKE '%$searchQuery%'";
				    $result = $conn->query($sql);

				    if ($result->num_rows > 0) {
				        while ($row = $result->fetch_assoc()) {
				            // Output the results
				            echo $row['field'] . "<br>";
				            // Output other columns as needed
				        }
				    } else {
				        echo "No results found";
				    }

				    // Close your database connection here
				}
				?>
				<table class="table table-striped table-hover" style="font-size:small;">
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

							

						   $user_disability = $_SESSION['disability'];
							
							
							$sql = "SELECT * FROM tasks WHERE disability = ? LIMIT $offset, $recordsPerPage";

							if ($stmt = $conn->prepare($sql)) {
							    $stmt->bind_param("s", $user_disability);
							    $stmt->execute();
							    $result = $stmt->get_result();

							    if ($result->num_rows > 0) {
							        $count = 1;
							        while ($row = $result->fetch_assoc()) {
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
										        echo "Mentally Disabled";
										    }
										    ?>
										</td>
						                <td><?php echo $row["field"]; ?></td>
						                <td><?php echo $row["Reward"]; ?></td>
						                <td><?php echo $row["expiry"]; ?></td>
						                
						                
						                <td>
                                            <?php
                                            // Date format conversion for comparison (adjust as per your date format)
                                            $currentDate = date('Y-m-d');
                                            $expiryDate = $row["expiry"];

                                            if ($currentDate <= $expiryDate) {
                                                // Task is within expiry date, check if the task is already claimed
                                                require_once('DBConnection.php'); // Ensure the connection is established

                                                // Assuming $conn is the database connection
                                                $task_id = $row["report_id"];

                                                // Query to check if the task is already claimed in mytasks table
                                               $check_query = "SELECT application_status FROM mytasks WHERE task_id = ? AND user_id = ? LIMIT 1";
												$stmt_check = $conn->prepare($check_query);
												$stmt_check->bind_param("ii", $task_id, $user_id); // Assuming user_id is an integer
												$stmt_check->execute();
												$stmt_check->store_result();
                                                // Display the appropriate button or status
                                                if ($stmt_check->num_rows > 0) {
                                                    $stmt_check->bind_result($application_status);
                                                    $stmt_check->fetch();

                                                    if ($application_status == 1) {
                                                        echo "Claimed";
                                                    } else {
                                                        echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#claimTaskModal' . $row["report_id"] . '">Claim</button>';
                                                    }
                                                } else {
                                                    echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#claimTaskModal' . $row["report_id"] . '">Claim</button>';
                                                }

                                                $stmt_check->close();
                                            } else {
                                                echo "Expired";
                                            }
                                            ?>
                                        </td>

						            </tr>
						    <?php
										$count++; // Increment count for the next row
								        }
								    } else {
								        echo "<tr><td colspan='8'>No tasks found</td></tr>";
								    }

								    $stmt->close();
								} else {
								    echo "Error in preparing the task retrieval statement.";
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
	

	<!-- Delete Modal HTML -->
	<?php
$result->data_seek(0); // Reset result pointer to start
while($row = $result->fetch_assoc()) {
    ?>
    <!-- Delete Modal for each staff member -->
    <div id="claimTaskModal<?php echo $row["report_id"]; ?>" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="tasks.php" method="post">
                    <div class="modal-header">						
                        <h4 class="modal-title">Claim task</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="task_id" value="<?php echo $row["report_id"]; ?>">
                        <p>Are you sure you want to claim this task?</p>
                        <p class="text-warning"><small>please make sure to complete this job.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-success" name="claim_task" value="Claim">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <?php
}
?>
   <?php include 'footer.php'?>