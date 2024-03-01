<?php
session_start();
require_once('DBConnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are empty
    if (empty(trim($_POST["email"])) || empty(trim($_POST["password"]))) {
        echo "Please enter your credentials.";
    } else {
        // Prepare a select statement to fetch user details including disability
        $sql = "SELECT user_id, email, password, disability, status FROM user_list WHERE email = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if email exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($user_id, $email, $hashed_password, $user_disability, $status);
                    if ($stmt->fetch()) {
                        // Verify password
                        if (password_verify($_POST['password'], $hashed_password)) {
                            if ($status == 1) {
                                // Password is correct and status is approved
                                $_SESSION["loggedin"] = true;
                                $_SESSION["user_id"] = $user_id;
                                $_SESSION["email"] = $email;
                                $_SESSION["disability"] = $user_disability; // Set user disability in session
                                header("location: dashboard.php");
                                exit();
                            } else {
                                // Status is not approved, inform the user
                                echo '<script>alert("Your account is pending! Please wait for admin approval.");</script>';

                            }
                        } else {
                            // Display an error message if password is not valid
                            echo '<script>alert("Invalid password.");</script>';
                        }
                    }
                } else {
                    // Display an error message if email doesn't exist
                    echo '<script>alert("Invalid email.");</script>';
                }
            } else {
                echo '<script>alert("Oops! Something went wrong.");</script>';
            }
            
            // Close statement
            $stmt->close();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | Job and Funds Allocation System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/custom.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/script.js"></script>
</head>

<body class="bg-dark bg-gradient">

  
   <div class="h-100 d-flex jsutify-content-center align-items-center">
       <div class='w-100'>
        <h3 class="py-5 text-center text-light">Job and Funds Allocation System</h3>
        <div class="card my-3 col-md-4 offset-md-4">
            <div class="card-body">
                <!-- Login Form Wrapper -->
                <form action="" id="login-form" method="post">
                    
                    <center><small>Please enter your credentials.</small></center>
                    <div class="mb-3">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" id="email" autofocus name="email" class="form-control rounded-0" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control rounded-0" required>
                    </div>
                    <div class="mb-3 d-flex w-100 justify-content-between  align-items-end">
                        <a href="registration.php">Does not have an Account? Signup Here</a>
                        <button class="btn btn-sm btn-primary rounded-0 my-1" name="submit">Login</button>
                    </div>
                </form>
                <!-- Login Form Wrapper -->
            </div>
        </div>
       </div>
   </div>
<section style="height: max-content;">
    <?php
  include 'footer_bar.php';
 

    ?>
</section>

</body>
<script>
    
</html>