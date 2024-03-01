<?php include 'head.php'?>
<?php


// Fetch user data from the database and populate the profile fields
// Display the profile information in an HTML structure

// Form submission handling for updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    // Retrieve updated form data
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password']; // Hash it if needed

    // Validate and sanitize the data

    // Perform database update
    $updateQuery = "UPDATE staffs SET name = ?, email = ?, password = ? WHERE id = ?";
    // Prepare statement, bind parameters, and execute query

    if ($success) {
        // Display success message
    } else {
        // Display error message
    }
}
?>


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


<?php include 'header.php'?>
<!-- Display profile information -->

            <?php include 'menu.php'?>
<!-- Create a form for updating profile -->
<div id="addEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="staff.php" method="post">
                    <div class="modal-header">                      
                        <h4 class="modal-title">Add Staff</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <!-- Form fields for updating profile -->
  
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="fullname" class="form-control" value="<?php echo $currentFullname; ?>" >
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $currentEmail; ?>" >
                        </div>
                        <div class="form-group">
                            <label>username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $currentUsername; ?>" >
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                              <input type="password" name="password" placeholder="New Password">
                        <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" name="submit"class="btn btn-success" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>

       <?php include 'footer.php'?>