<?php
session_start();
require_once('DBConnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are empty
    if (empty(trim($_POST["email"])) || empty(trim($_POST["password"]))) {
        echo "Please enter your credentials.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM admin WHERE email = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if email exists
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $email, $plain_text_password);
                    if ($stmt->fetch()) {
                        // Verify password (directly compare plain text passwords)
                        if ($_POST['password'] === $plain_text_password) {
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["admin_id"] = $id;
                            $_SESSION["email"] = $email;

                            // Redirect user to dashboard
                            header("location: home.php");
                        } else {
                            // Display an error message if password is not valid
                            echo "Invalid password.";
                        }
                    }
                } else {
                    // Display an error message if email doesn't exist
                    echo "Invalid email.";
                }
            } else {
                echo "Oops! Something went wrong.";
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
    <title>LOGIN | Task Allocation System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/custom.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/script.js"></script>
</head>

<body class="bg-dark bg-gradient">

    <?php
  include 'title_bar.php';
    include 'navigation_bar.php'

    ?>
   <div class="h-100 d-flex jsutify-content-center align-items-center">
       <div class='w-100'>
        <h3 class="py-5 text-center text-light">Task Allocation System</h3>
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