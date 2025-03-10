<?php
// contact.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Validate inputs: Ensure fields are not empty and the email is valid
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // You could redirect back or display an error message
        echo "Please fill out the form correctly.";
        exit;
    }

    // Set the recipient email address (for now)
    $recipient = "Hhenderson2018@gmail.com";

    // Create the email subject
    $subject = "New Contact Form Submission from " . $name;

    // Build the email content
    $email_content  = "Name: " . $name . "\n";
    $email_content .= "Email: " . $email . "\n\n";
    $email_content .= "Message:\n" . $message . "\n";

    // Build the email headers
    $email_headers = "From: " . $name . " <" . $email . ">";

    // Send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        echo "Thank you! Your message has been sent.";
    } else {
        echo "Oops! Something went wrong, and we couldn't send your message.";
    }
} else {
    // If not a POST request, you might want to redirect or show an error
    echo "There was a problem with your submission, please try again.";
}
?>
