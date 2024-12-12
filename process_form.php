<?php
// process_form.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include 'db_connection.php';

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $service = $_POST['service'];
    $email = $_POST['email'];

    // Set the recipient email addresses
    $to1 = "rsmongau@gmail.com"; // Replace with the first email address
    $to2 = "yungcopel@gmail.com"; // Replace with the second email address

    // Subject and message
    $subject = "New Quote Request";
    $message = "Service Requested: " . $service . "\n";
    $message .= "Email: " . $email . "\n";

    // Headers
    $headers = "From: noreply@realsteelprojects.co.za"; // Replace with your domain

    // Send email to both addresses
    mail($to1, $subject, $message, $headers);
    mail($to2, $subject, $message, $headers);

    // Redirect or display a success message
    echo "Your request has been sent successfully!";
} else {
    // If the form is not submitted, redirect back to the form
    header("Location: index.html");
    exit();
}

// Close the connection
$conn->close();
?>
