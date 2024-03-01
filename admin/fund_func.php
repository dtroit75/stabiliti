<?php
// Establish database connection
require_once('DBConnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_fund'])) {
    // Retrieve form data
    $sponsor = $_POST['sponsor'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    // Prepare an SQL statement to insert data into the funds table
    $sql = "INSERT INTO funds (sponsor, description, category, amount, payment_method) VALUES (?, ?, ?, ?, ?)";

    // Create a prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("sssis", $sponsor, $description, $category, $amount, $payment_method);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Data inserted successfully
            echo '<script>alert("Fund added successfully.");</script>';
            header("Location: fund_allocation.php");
        
        } else {
            // Error handling if the insertion fails
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_fund'])) {
    // Retrieve form data
    $fund_id = $_POST['fund_id'];
    $sponsor = $_POST['sponsor'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    // Prepare SQL statement to update the funds table
    $sql = "UPDATE funds SET sponsor=?, description=?, category=?, amount=?, payment_method=? WHERE id=?";

    // Create a prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("sssssi", $sponsor, $description, $category, $amount, $payment_method, $fund_id);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Display a success message or perform any necessary actions
            header("Location: fund_allocation.php");
            echo '<script>alert("Fund updated successfully.");</script>';
        } else {
            // Display an error message if the execution fails
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>


<?php
// Check if the form is submitted for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_fund'])) {

    $fund_id = $_POST['fund_id'];

    // Perform deletion in the database
    $sql = "DELETE FROM funds WHERE id='$fund_id'";
    if ($conn->query($sql) === TRUE) {
        // If deletion successful, redirect to the original page or any other desired page
        header("Location: fund_allocation.php");
        exit();
    } else {
        // If deletion fails, handle the error (display an error message or log it)
        echo "Error deleting record: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>

