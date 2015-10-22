<?php


if( $_SERVER['REQUEST_METHOD'] !== "POST") {
    header("HTTP/1.0 403 Forbidden");
    echo "There was a problem with your submission, please try again.";
    exit;
}

$name     = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email    = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$activity  = filter_input(INPUT_POST, 'activity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$description  = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


// Check that data was sent to the mailer.
if ( empty($name) || empty($activity) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    // Set a 400 (bad request) response code and exit.
    header("HTTP/1.0 400 Bad Request");
    echo "Oops! You forgot one or a few fields. Please complete the form and try again.";
    exit;
}

// Set the recipient email address.
$recipient = "hi@michellewelin.com";

// Set the email subject.
$subject = "New contact from $name";

// Build the email content.
$email_content = "Name: $name\n";
$email_content .= "Email: $email\n\n";
$email_content .= "Activity:\n$activity\n";
$email_content .= "Description:\n$description\n";

// Build the email headers.
$email_headers = "From: $name <$email>";

// Send the email.
if (mail($recipient, $subject, $email_content, $email_headers)) {
    // Set a 200 (okay) response code.
    header('HTTP/1.0 200 OK');
    echo "Thank You! Your message has been sent. Your activity will be shown in a while.";
} else {
    // Set a 500 (internal server error) response code.
    header('HTTP/1.0 500 Internal Server Error');
    echo "Oops! Something went wrong,we couldn't send your message. Try again!";
}
?>