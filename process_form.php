<?php
// process_form.php: emails quote and contact requests from the site forms.

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit();
}

function field($key) {
    $value = isset($_POST[$key]) ? trim((string) $_POST[$key]) : '';
    // Strip line breaks from single-line fields so they cannot inject mail headers.
    return $key === 'message' ? $value : str_replace(["\r", "\n"], ' ', $value);
}

$name    = field('name');
$email   = filter_var(field('email'), FILTER_VALIDATE_EMAIL) ?: '';
$phone   = field('phone');
$service = field('service');
$message = field('message');
$from    = preg_replace('/[^a-z]/', '', field('from'));

$to1 = "rsmongau@gmail.com";
$to2 = "yungcopel@gmail.com";

$subject = "New quote request" . ($service !== '' ? ": " . $service : "");
$body  = "Name: " . $name . "\n";
$body .= "Email: " . $email . "\n";
$body .= "Phone: " . $phone . "\n";
$body .= "Service: " . $service . "\n\n";
$body .= $message . "\n";

$headers = "From: noreply@realsteelprojects.co.za";
if ($email !== '') {
    $headers .= "\r\nReply-To: " . $email;
}

mail($to1, $subject, $body, $headers);
mail($to2, $subject, $body, $headers);

$pages = ['home' => 'index.html', 'services' => 'services.html', 'contact' => 'contact.html'];
$back = isset($pages[$from]) ? $pages[$from] : 'contact.html';
header("Location: " . $back . "?sent=1#quote");
exit();
