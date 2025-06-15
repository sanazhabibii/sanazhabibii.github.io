<?php
// Change this to your email address
$receiving_email_address = 'sanazhabibi.imm@gmail.com';

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input values
    $name    = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email address.";
        exit;
    }

    // Compose the email
    $email_subject = "New Contact Form Submission: $subject";
    $email_body = "You received a new message from your website contact form.\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n\n";
    $email_body .= "Message:\n$message\n";

    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send the email
    if (mail($receiving_email_address, $email_subject, $email_body, $headers)) {
        echo "Message sent successfully.";
    } else {
        http_response_code(500);
        echo "Failed to send message.";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission.";
}
?>
