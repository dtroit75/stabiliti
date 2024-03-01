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
$user_id = $_SESSION['user_id'];

// Perform database connection here and your SQL query execution

$sql = "SELECT user_id, fullname, username, type, status, date_created, email, mobile, employment, job_title, field, education, disability, experience, id_no, ncpwd_no FROM user_list WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();

    // Assign fetched values to variables
    $fullname = $row['fullname'];
    $email = $row['email'];
    $mobile = $row['mobile'];
    $employment = $row['employment'];
    $job_title = $row['job_title'];
    $field = $row['field'];
    $education = $row['education'];
    $disability = $row['disability'];
    $experience = $row['experience'];
    $id_no = $row['id_no'];
    $ncpwd_no = $row['ncpwd_no'];


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
                        <label for="inputName" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <?php
                            // Echo the fetched value
                            echo '<input type="text" readonly class="form-control-plaintext" id="inputName" value="' . $fullname . '">';
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
                    <div class="form-group row">
                        <label for="inputEmployment" class="col-sm-4 col-form-label">Employment</label>
                        <div class="col-sm-8">
                            <?php
                            // Echo the fetched value
                            echo '<input type="text" readonly class="form-control-plaintext" id="inputEmployment" value="' . $employment . '">';
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputJobTitle" class="col-sm-4 col-form-label">Job Title</label>
                        <div class="col-sm-8">
                            <?php
                            // Echo the fetched value
                            echo '<input type="text" readonly class="form-control-plaintext" id="inputJobTitle" value="' . $job_title . '">';
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputField" class="col-sm-4 col-form-label">Field</label>
                        <div class="col-sm-8">
                            <?php
                            // Echo the fetched value
                            echo '<input type="text" readonly class="form-control-plaintext" id="inputField" value="' . $field . '">';
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEducation" class="col-sm-4 col-form-label">Education</label>
                        <div class="col-sm-8">
                            <?php
                            // Echo the fetched value
                            echo '<input type="text" readonly class="form-control-plaintext" id="inputEducation" value="' . $education . '">';
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputDisability" class="col-sm-4 col-form-label">Disability</label>
                        <div class="col-sm-8">
                             <?php
                                // Conditionally set the disability text based on the value
                                $disabilityText = ($disability == 0) ? "Physically Disabled" : "Mentally Disabled";
                                
                                // Output the disability text in an input field
                                echo '<input type="text" readonly class="form-control-plaintext" id="inputDisability" value="' . $disabilityText . '">';
                                ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputExperience" class="col-sm-4 col-form-label">Experience</label>
                        <div class="col-sm-8">
                            <?php
                            // Echo the fetched value
                            echo '<input type="text" readonly class="form-control-plaintext" id="inputExperience" value="' . $experience . '">';
                            ?>years
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputIdNo" class="col-sm-4 col-form-label">ID Number</label>
                        <div class="col-sm-8">
                            <?php
                            // Echo the fetched value
                            echo '<input type="text" readonly class="form-control-plaintext" id="inputIdNo" value="' . $id_no . '">';
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputNcpwdNo" class="col-sm-4 col-form-label">NCPWD Number</label>
                        <div class="col-sm-8">
                            <?php
                            // Echo the fetched value
                            echo '<input type="text" readonly class="form-control-plaintext" id="inputNcpwdNo" value="' . $ncpwd_no . '">';
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