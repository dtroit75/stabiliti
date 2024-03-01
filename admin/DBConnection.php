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
?>
