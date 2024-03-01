<?php

require_once('DBConnection.php');
// Check if the form for claiming tasks is submitted
if(isset($_POST['claim_task'])) {
    // Assuming DBConnection.php has the database connection
  
    
    // Get the task ID from the form
    $task_id = $_POST['task_id'];

    // Retrieve user ID from the session (assuming user email is stored in the session)
    session_start();
    if(isset($_SESSION['email'])) {
        $user_email = $_SESSION['email'];

        // Retrieve user ID from the user_list table based on the email
        $user_query = "SELECT user_id FROM user_list WHERE email = ?";
        $stmt_user = $conn->prepare($user_query);
        $stmt_user->bind_param("s", $user_email);
        $stmt_user->execute();
        $stmt_user->bind_result($user_id);
        $stmt_user->fetch();
        $stmt_user->close();

        // Prepare and execute the SQL statement to update mytasks table with task ID and user ID
        if ($user_id !== null) {
            $update_query = "INSERT INTO mytasks (task_id, user_id, application_status, completion_status) VALUES (?, ?, 1, 0)";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ii", $task_id, $user_id);

            if ($stmt->execute()) {
                // Update successful
                // Redirect to a success page or refresh the current page
                header("Location: manage_tasks.php");
                exit();
            } else {
                // Handle errors if the update fails
                echo "Error updating task: " . $conn->error;
            }

            // Close statement and connection
            $stmt->close();
        } else {
            echo "User ID not found.";
        }
    } else {
        echo "User email not found in session.";
    }
}
?>


<?php
// Check if the form for claiming tasks is submitted
if(isset($_POST['submit_task'])) {
 
    $task_id = $_POST['task_id'];

    $update_query = "UPDATE mytasks SET completion_status = 1, payment_status = 1 WHERE task_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        // Update successful
        // Redirect to a success page or refresh the current page
        header("Location: mytasks.php");
        exit();
    } else {
        // Handle errors if the update fails
        echo "Error updating task: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

}
?>
