<?php include 'head.php'?>



<?php
// Assuming you have established a database connection ($conn)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullname = $_POST['editName'];
    $username = $_POST['editUsername'];
    $email = $_POST['editEmail'];
    $mobile = $_POST['editMobile'];
    $password = $_POST['password']; // This should be securely hashed before storing in the database

    // Get the email from the session
    $sessionEmail = $_SESSION['email']; // Assuming 'email' is stored in the session

    // Prepare and execute SQL statement to update data in the admin table based on the email
    $update_query = "UPDATE admin SET fullname = ?, username = ?, email = ?, mobile = ?, password = ? WHERE email = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssss", $fullname, $username, $email, $mobile, $password, $sessionEmail);

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Data updated successfully
        echo "Data updated successfully in admin table.";
    } else {
        // Error occurred
        echo "Error updating data in admin table: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
  
}
?>



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

<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

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

</head>
<?php include 'header.php'?>
    <?php include 'menu.php'?>



         <!-- Show success message if set -->
    <?php if (!empty($successMessage)) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>




<div class="container mt-5">
     
<?php
// session_start(); // Make sure you have session_start() at the beginning of the file

// Assuming the user_id is stored in the session
$email = $_SESSION['email'];

// Perform database connection here and your SQL query execution

$sql = "SELECT email, fullname, username, mobile FROM admin WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();

    // Assign fetched values to variables
    $fullname = $row['fullname'];
    $username = $row['username'];
    $email = $row['email'];
    $mobile = $row['mobile'];

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
}
?>


<!-- Your HTML structure -->

<style type="text/css">
    .form-control-plaintext{
        font-size: small;
    }

</style>



<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="" method="post" style="font-size: large;">
                <div class="form-group" >
                        <label for="editName">Full Name</label>
                        <input type="text" class="form-control" id="editName" name="editName" value="<?php echo $fullname; ?>" style="font-size:small;">
                    </div>
                    <div class="form-group">
                        <label for="editUsername">Username</label>
                        <input type="text" class="form-control" id="editUsername" name="editUsername" value="<?php echo $username; ?>" style="font-size:small;">
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="editEmail" value="<?php echo $email; ?>" style="font-size:small;">
                    </div>
                    <div class="form-group">
                        <label for="editMobile">Mobile</label>
                        <input type="text" class="form-control" id="editMobile" name="editMobile" value="<?php echo $mobile; ?>" style="font-size:small;">
                    </div>
                    
                    <div class="form-group">
                        <label for="editNcpwdNo">Create New Password</label>
                        <input type="text" class="form-control" id="editNcpwdNo" name="password" value="" style="font-size:small;">
                    </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                   <a href="profile.php"> <button type="button" class="btn btn-secondary">Close</button></a>
                </div>
            </form>
        </div>
    </div>
</div>


</div>

</div>
 </div>

 </html>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <?php include 'footer.php'?>