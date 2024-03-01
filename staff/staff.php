<?php


require_once('DBConnection.php');

$successMessage = '';

if(isset($_POST['submit'])) {
    // Retrieve form data and sanitize it
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);
     $password = $_POST['password']; // Not sanitized as we'll hash it

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute SQL statement to insert data into the staffs table
    $sql = "INSERT INTO staffs (fullname, email, username, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $fullname, $email, $username, $hashedPassword);

    if ($stmt->execute()) {
        $successMessage = "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_staff'])) {

    $staff_id = $_POST['staff_id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    // Update staff information in the database
    $sql = "UPDATE staffs SET fullname='$fullname', email='$email', username='$username' WHERE id='$staff_id'";
    if ($conn->query($sql) === TRUE) {
        // If update successful, redirect to the original page or any other desired page
        header("Location: manage_staffs.php");
        exit();
    } else {
        // If update fails, handle the error (display an error message or log it)
        echo "Error updating record: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>


<?php
// Check if the form is submitted for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_staff'])) {

    $staff_id = $_POST['staff_id'];

    // Perform deletion in the database
    $sql = "DELETE FROM staffs WHERE id='$staff_id'";
    if ($conn->query($sql) === TRUE) {
        // If deletion successful, redirect to the original page or any other desired page
        header("Location: manage_staffs.php");
        exit();
    } else {
        // If deletion fails, handle the error (display an error message or log it)
        echo "Error deleting record: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>
