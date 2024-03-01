<?php
require_once('DBConnection.php');

$successMessage = '';

if(isset($_POST['add_task'])) {
    // Retrieve form data and sanitize it
    $task_id = htmlspecialchars($_POST['task_id']);
    $description = htmlspecialchars($_POST['description']);
    $eligibility = htmlspecialchars($_POST['eligibility']);
    $reward = htmlspecialchars($_POST['reward']);
    $field = htmlspecialchars($_POST['field']);
    $expiry_date = htmlspecialchars($_POST['expiry']); // Assuming this is from the form

    // Set the current timestamp for date_created
    $date_created = date('Y-m-d H:i:s');

    // Prepare and execute SQL statement to insert data into the task_report table
    $sql = "INSERT INTO tasks (taskID, date_created, description, disability, Reward, field, expiry) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $task_id, $date_created, $description, $eligibility, $reward, $field, $expiry_date);

    if ($stmt->execute()) {
        header("Location: manage_tasks.php");
        exit();
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>



<?php
// Assuming you have established a database connection already

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_task'])) {
    // Retrieve form data and sanitize inputs
    $task_id = $_POST['task_id'];
    $expiry = $_POST['expiry'];
    $description = $_POST['description'];
    $eligibility = $_POST['eligibility'];
    $reward = $_POST['reward'];
    $field = $_POST['field'];

    // Prepare and execute SQL statement to insert data into the task table
    $sql = "INSERT INTO tasks (taskID, expiry, description, disability, reward, field) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssis", $task_id, $expiry, $description, $eligibility, $reward, $field);

    if ($stmt->execute()) {
        header("Location: manage_tasks.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>



<?php
// Check if the form is submitted for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_task'])) {

    $task_id = $_POST['task_id'];

    // Perform deletion in the database
    $sql = "DELETE FROM tasks WHERE report_id='$task_id'";
    if ($conn->query($sql) === TRUE) {
        // If deletion successful, redirect to the original page or any other desired page
        header("Location: manage_tasks.php");
        exit();
    } else {
        // If deletion fails, handle the error (display an error message or log it)
        echo "Error deleting record: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>
