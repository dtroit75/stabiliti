

<?php

    // Assigning values to variables.
    $conn_error = 'Error in connecting to server';
    $mysql_host = 'localhost';
    $mysql_user = 'root';
    $mysql_pass = '';
    $mysql_db = 'sqlsys';
    
    // Code for server connection and database connection.
    $conn = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
    if (!$conn) {
        die($conn_error);
    }


// Your database connection code remains the same

if (isset($_POST['submit'])) {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $employment = $_POST['employment'];
    $id_no = $_POST['id_no'];
    $ncpwd_no = $_POST['ncpwd_no'];
    $jobTitle = $_POST['job-title'];
    $field = $_POST['field'];
    $experience = $_POST['experience'];
    $disability = $_POST['disability'];
    $education = $_POST['education'];
    $password = $_POST['password'];

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    // Prepare a SQL statement with placeholders
    $sql = "INSERT INTO user_list (fullname, username, email, mobile, employment, id_no, ncpwd_no, job_title, field, experience, disability, education, password)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Assuming these are the variables you want to bind
    $stmt->bind_param("sssssssssssss", $fullname, $username, $email, $mobile, $employment, $id_no, $ncpwd_no, $jobTitle, $field, $experience, $disability, $education, $hashedPassword);


    // Execute the prepared statement
    if ($stmt->execute()) {
    // Display an alert to inform the user
        echo '<script>alert("Your application has been sent successfully. Please wait for admin approval.");</script>';
        
        // Redirect the user to the login page after showing the alert
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error; // Output any errors
    }
    $stmt->close(); // Close the statement
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration |  Login and Registration</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/custom.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/script.js"></script>
</head>
<body class="bg-dark bg-gradient">

   
    </div><br><br>
   <div class="h-100 d-flex jsutify-content-center align-items-center">
       <div class='w-100'>
        <h1 class="py-5 text-center text-light">Create a New Account</h1>
        <div class="card my-3 col-md-4 offset-md-4">
            <div class="card-body">
                <!-- Registration Form Wrapper -->
<form action="" id="register-form" method="post">
    <input type="hidden" name="formToken" value="<?= $_SESSION['formToken']['registration'] ?>">
    <center><h3>Please enter your credentials.</h3></center>
    
    <!-- Personal Details Section -->
    <div class="mb-3">
        <h5>Personal Details</h5>
        <div class="row">
            <div class="col-md-6">
                <label for="fullname" class="control-label">Full Name</label>
                <input type="text" id="fullname" autofocus name="fullname" class="form-control rounded-0" required>
            </div>
            <div class="col-md-6">
                <label for="username" class="control-label">Username</label>
                <input type="text" id="username" name="username" class="form-control rounded-0" required>
            </div>

             <div class="col-md-6">
                <label for="email" class="control-label">Email</label>
                <input type="email" id="email" autofocus name="email" class="form-control rounded-0" required>
            </div>
            <div class="col-md-6">
                <label for="mobile" class="control-label">Mobile Number</label>
                <input type="text" id="mobile" name="mobile" class="form-control rounded-0" required>
            </div>
            <div class="col-md-6">
                <label for="id_no" class="control-label">ID Number</label>
                <input type="text" id="id_no" name="id_no" class="form-control rounded-0" required>
            </div>
        </div>
    </div>
    
    <!-- Employment Details Section -->
    <div class="mb-3">
        <h5>Employment Details</h5>
        <div class="row">
            <div class="col-md-6">
                <label for="employment" class="control-label">Employment Status</label>
                <select id="employment" name="employment" class="form-control rounded-0">
                    <option value="employed">Employed</option>
                    <option value="not-employed">Not Employed</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="col-md-6">
                <label for="job-title" class="control-label">Job Title</label>
                <input type="text" id="job-title" name="job-title" class="form-control rounded-0">
            </div>

             <div class="col-md-6">
                <label for="field" class="control-label">Field</label>
                <select id="field" name="field" class="form-control rounded-0">
                                <option value="Teaching">Teaching</option>
                                <option value="Software Development">Software Development</option>
                                <option value="Customer Service">Customer Service</option>
                                <option value="Graphic Design">Graphic Design</option>
                                <option value="Data Entry">Data Entry</option>
                                <option value value="Architecture"><li>Architecture / Interior Design</li></option>
                               
                                
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="col-md-6">
                <label for="experience" class="control-label">Experience Level</label>
                <select id="experience" name="experience" class="form-control rounded-0">
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
        </div>
    </div>
    
    <!-- Other Details Section -->
    <div class="mb-3">
        <h5>Other Details</h5>
        <div class="row">
            <div class="col-md-6">
                <label for="disability" class="control-label">Disability Type</label>
                <select id="disability" name="disability" class="form-control rounded-0">
                    <option value="0">Intellectual Disabled</option>
                    <option value="1">Physically Disabled</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="cpassword" class="control-label">NCPWD</label>
                <input type="text" id="ncpwd_no" name="ncpwd_no" class="form-control rounded-0" required>
            </div>
            <div class="col-md-6">
                <label for="education" class="control-label">Education Level</label>
                <select id="education" name="education" class="form-control rounded-0">
                    <option value="High School">High School</option>
                    <option value="Diploma">Diploma</option>
                    <option value="Graduate">Graduate</option>
                    <option value="Post-Graduate">Post-Graduate</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
           <div class="col-md-6">
                <label for="password" class="control-label">Create Password</label>
                <input type="text" id="password" autofocus name="password" class="form-control rounded-0" required>
            </div>
           

        </div>
    </div>
    
    <!-- Submit Button -->
    <div class="mb-3 d-flex w-100 justify-content-between align-items-end">
        <a href="login.php">Already have an Account? Login here</a>
        <button class="btn btn-sm btn-primary rounded-0 my-1" name="submit">Register</button>
    </div>
</form>

                <!-- Registration Form Wrapper -->
            </div>
        </div>
       </div>
   </div>

</body>
</html>