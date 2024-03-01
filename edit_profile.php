<?php include 'head.php'?>



<?php
// Place this code at the top of the file to handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullname = $_POST['editName'];
    $username = $_POST['editUsername'];
    $email = $_POST['editEmail'];
    $mobile = $_POST['editMobile'];
    $employment = $_POST['employment'];
    $job_title = $_POST['editJobTitle'];
    $field = $_POST['field'];
    $education = $_POST['education'];
    $disability = $_POST['disability'];
    $experience = $_POST['experience'];
    $id_no = $_POST['editIdNo'];
    $ncpwd_no = $_POST['editNcpwdNo'];

    // Update user data in the database using SQL UPDATE statement
    $sql = "UPDATE user_list SET fullname=?, username=?, email=?, mobile=?, employment=?, job_title=?, field=?, education=?, disability=?, experience=?, id_no=?, ncpwd_no=? WHERE user_id=?";
    
    // Assuming $conn is your database connection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssss", $fullname, $username, $email, $mobile, $employment, $job_title, $field, $education, $disability, $experience, $id_no, $ncpwd_no, $_SESSION['user_id']);
    
    // Execute the update statement
    $stmt->execute();
    
    // Close the prepared statement
    $stmt->close();
    
    // Redirect to a success page or perform any other necessary actions after update
    header("Location: update_profile.php");
    exit();
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
    $username = $row['username'];
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



<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="" method="post" style="font-size: large;">
                <div class="form-group" >
                        <label for="editName">Name</label>
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
                        <label for="editEmployment">Employment</label>
                        
                        <select id="employment" name="employment" class="form-control rounded-0" style="font-size:small;">
		                    <option value="employed">Employed</option>
		                    <option value="not-employed">Not Employed</option>
		                    <!-- Add more options as needed -->
		                </select>
                    </div>
                    <div class="form-group">
                        <label for="editJobTitle">Job Title</label>
                        <input type="text" class="form-control" id="editJobTitle" name="editJobTitle" value="<?php echo $job_title; ?>" style="font-size:small;">
                    </div>
                    <div class="form-group">
                        <label for="editField">Field</label>
                       
                        <select id="employment" name="field" class="form-control rounded-0" style="font-size:small;">
                                <option value="Teaching">Teaching</option>
                                <option value="Software Development">Software Development</option>
                                <option value="Customer Service">Customer Service</option>
                                <option value="Graphic Design">Graphic Design</option>
                                <option value="Data Entry">Data Entry</option>
                                <option value value="Architecture"><li>Architecture / Interior Design</li></option>

                		</select>
                    </div>
                    <div class="form-group">
                        <label for="editEducation">Education</label>
                        
                        <select id="employment" name="education" class="form-control rounded-0" style="font-size:small;">
		                    <option value="High School">High School</option>
		                    <option value="Diploma">Diploma</option>
		                    <option value="Graduate">Graduate</option>
		                    <option value="Post-Graduate">Post-Graduate</option>
		                    <!-- Add more options as needed -->
		                </select>
                    </div>
                    <div class="form-group">
                        <label for="editDisability">Disability</label>
                        
                        <select id="employment" name="disability" class="form-control rounded-0" style="font-size:small;">
		                    <option value="0">Mentally Disabled</option>
		                    <option value="1">Physically Disabled</option>
		                </select>

                    </div>
                    <div class="form-group">
                        <label for="editExperience">Experience</label>
                        
                        <select id="employment" name="experience" class="form-control rounded-0" style="font-size:small;">
                                <option value="0">Fresher</option>
                                <option value="1">1 Year</option>
                                <option value="2">2 Years</option>
                                <option value="3">3 Years</option>
                                <option value="4">4 Years</option>
                                <option value="5">5 Years</option>
                                <option value="6">6 Years</option>
                                
                    <!-- Add more options as needed -->
                </select>
                    </div>
                    <div class="form-group">
                        <label for="editIdNo">ID Number</label>
                        <input type="text" class="form-control" id="editIdNo" name="editIdNo" value="<?php echo $id_no; ?>" style="font-size:small;">
                    </div>
                    <div class="form-group">
                        <label for="editNcpwdNo">NCPWD Number</label>
                        <input type="text" class="form-control" id="editNcpwdNo" name="editNcpwdNo" value="<?php echo $ncpwd_no; ?>" style="font-size:small;">
                    </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


</div>

</div>
 </div>

 </html>
<script>
    function toggleEmployment() {
        const currentValue = document.getElementById('editEmployment');
        const selectField = document.getElementById('employment');

        // Toggle display between current value and select field
        if (currentValue.style.display !== 'none') {
            currentValue.style.display = 'none';
            selectField.style.display = 'block';
        } else {
            currentValue.style.display = 'block';
            selectField.style.display = 'none';
        }
    }
</script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <?php include 'footer.php'?>