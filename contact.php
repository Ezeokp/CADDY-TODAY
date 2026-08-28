<?php
header('Content-Type: application/json; charset=UTF-8');

function respond($success, $message, $code = 200) {
    http_response_code($code);
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request.', 405);
}

if (!empty($_POST['website'] ?? '')) {
    respond(true, 'Thank you.');
}

$formType = trim($_POST['form_type'] ?? '');
$email = trim($_POST['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Please enter a valid email address.', 400);
}

$recipient = 'Hhenderson2018@gmail.com';
$headers = "From: Caddy Website <noreply@caddykits.com>\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if ($formType === 'waitlist') {
    $subject = 'New Caddy Waitlist Signup';
    $content = "New Caddy waitlist signup.\n\n";
    $content .= "Email: {$email}\n";
    $content .= "Date: " . date('Y-m-d H:i:s') . "\n";

    if (mail($recipient, $subject, $content, $headers)) {
        respond(true, "You're on the list. We'll keep you updated.");
    }

    respond(false, 'We could not add you to the waitlist. Please try again.', 500);
}

if ($formType === 'contact') {
    $name = trim(strip_tags($_POST['name'] ?? ''));
    $message = trim($_POST['message'] ?? '');
    $subjectInput = trim(strip_tags($_POST['subject'] ?? ''));

    $name = str_replace(["\r", "\n"], '', $name);
    $subjectInput = str_replace(["\r", "\n"], '', $subjectInput);

    if ($name === '') {
        respond(false, 'Please enter your name.', 400);
    }

    if ($message === '') {
        respond(false, 'Please enter your message.', 400);
    }

    $subject = $subjectInput !== ''
        ? 'Caddy Website: ' . $subjectInput
        : 'New Caddy Website Inquiry';

    $content = "New message from the Caddy website.\n\n";
    $content .= "Name: {$name}\n";
    $content .= "Email: {$email}\n";

    if ($subjectInput !== '') {
        $content .= "Subject: {$subjectInput}\n";
    }

    $content .= "\nMessage:\n{$message}\n";

    if (mail($recipient, $subject, $content, $headers)) {
        respond(true, 'Thank you. Your message has been sent.');
    }

    respond(false, 'Your message could not be sent. Please try again.', 500);
}

respond(false, 'Invalid form submission.', 400);
?>