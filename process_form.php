<?php
// process_form.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include 'db_connection.php';

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['Name'])) {
        // Contact form submission
        $name = htmlspecialchars($_POST['Name']);
        $phone = htmlspecialchars($_POST['Phone']);
        $email = htmlspecialchars($_POST['Email']);
        $message = htmlspecialchars($_POST['Message']);
        
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO contact_submissions (name, phone, email, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $phone, $email, $message);
    } elseif (isset($_POST['clientName'])) {
        // Quote request form submission
        $service = htmlspecialchars($_POST['service']);
        $clientName = htmlspecialchars($_POST['clientName']);
        $clientEmail = htmlspecialchars($_POST['clientEmail']);
        $clientMessage = htmlspecialchars($_POST['clientMessage']);
        
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO quote_requests (service, client_name, client_email, client_message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $service, $clientName, $clientEmail, $clientMessage);
    }

    // Execute the statement
    if ($stmt->execute()) {
        // Optionally, send an email notification to the admin
        $to = "yungcopel@gmail.com"; // Replace with admin's email
        $subject = "New Contact Form Submission";
        $body = "Name: $name\nPhone: $phone\nEmail: $email\nMessage: $message\n";
        mail($to, $subject, $body);
        
        header("Location: success.php"); // Redirect to a success page
        exit();
    } else {
        echo "Error: " . $stmt->error; // Display error if execution fails
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
