<?php
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$email_it_to = "divyams418@gmail.com";

$response_array = array("message" => "", "name_error" => "" , "email_error" => "" , "subject_error" => "", "message_error" => "");

$name  = $_POST['register_customer_name'] ?? '';
$email = $_POST['register_customer_email'] ?? '';
$reg_subject = $_POST['register_contact_subject'] ?? '';
$text_message = $_POST['register_contact_message'] ?? '';

$subject = 'Message from ' . $name;
$body = '

<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse;">
 <tr>
    <th colspan="2"><h4>Details</h4></th>
  </tr>
  <tr>
    <th align="left">Customer Name</th>
    <td>' . $name . '</td>
  </tr>
  <tr>
    <th align="left">Customer Email</th>
    <td>' . $email . '</td>
  </tr>
   <tr>
    <th align="left">Subject</th>
    <td>' . $reg_subject . '</td>
  </tr>
   <tr>
    <th align="left">Message</th>
    <td>' . $text_message . '</td>
  </tr>
</table>';

$body = wordwrap($body, 70);

// Validation
if (trim($name) === '') {
    $response_array["name_error"] = "empty";
}
if (trim($email) === '') {
    $response_array["email_error"] = "empty";
}
if (trim($reg_subject) === '') {
    $response_array["subject_error"] = "empty";
}
if (trim($text_message) === '') {
    $response_array["message_error"] = "empty";
}

if ($response_array["name_error"] || $response_array["email_error"] || $response_array["subject_error"]|| $response_array["message_error"]) {
    $response_array["message"] = "Please fill the details, and try again!";
    echo json_encode($response_array);
    exit;
}

// Send Email using PHPMailer
$mail = new PHPMailer(true);

try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'divyams418@gmail.com'; // your Gmail
    $mail->Password   = 'txkc bwkc fivx tmxh'; // Gmail app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Sender and recipient
    $mail->setFrom($email, 'Portfolio - Divya');
    $mail->addAddress($email_it_to); // Receiving email

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();

    $response_array = array(
        "message" => "Thank you! We have received your request",
        "name_error" => "sent",
        "email_error" => "sent",
        "subject_error" => "sent",
        "message_error" => "sent"
    );
} catch (Exception $e) {
    $response_array = array(
        "message" => "Unable to send your request! Mailer Error: " . $mail->ErrorInfo,
        "name_error" => "",
        "email_error" => "",
        "subject_error" => "",
        "message_error" => ""
    );
}

echo json_encode($response_array);
