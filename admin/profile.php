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
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>User Profile</h2>
                </div>
                <div class="card-body" style="font-size:large;">
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label">Full Name</label>
                        <div class="col-sm-8">
                            <?php
                            // Echo the fetched value
                            echo '<input type="text" readonly class="form-control-plaintext" id="inputName" value="' . $fullname . '">';
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <?php
                            // Echo the fetched value
                            echo '<input type="text" readonly class="form-control-plaintext" id="inputName" value="' . $username . '">';
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <?php
                            // Echo the fetched value
                            echo '<input type="text" readonly class="form-control-plaintext" id="inputEmail" value="' . $email . '">';
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputMobile" class="col-sm-4 col-form-label">Mobile</label>
                        <div class="col-sm-8">
                            <?php
                            // Echo the fetched value
                            echo '<input type="text" readonly class="form-control-plaintext" id="inputMobile" value="' . $mobile . '">';
                            ?>
                        </div>
                    </div>
                    
                  <a href="edit_profile.php" class="btn btn-primary" style="font-size: large;">Edit Profile</a>


                </div>
            </div>
        </div>
    </div>
</div>



</div>

</div>
 </div>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <?php include 'footer.php'?>