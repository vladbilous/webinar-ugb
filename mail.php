<?php
// Enable CORS policy
header("Access-Control-Allow-Origin: https://www.ukrgasbank.com");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: X-Requested-With");

$name = $email = $tel = $company = $suggestions = $position = $lastname = $city = $industry = $need = $question = '';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
  exit( 'Wrong request' );
}

$name = test_input( $_POST["name"] );
if ( $name == '' ) {
  http_response_code(400);
  header('Content-type: application/json');
  exit(json_encode("Ім'я є обов'язковим полем"));
}

$email = test_input($_POST["email"]);
$position = test_input($_POST["position"]);
$lastname = test_input($_POST["lastname"]);
$city = test_input($_POST["city"]);
$industry = test_input($_POST["industry"]);
$need = test_input($_POST["need"]);
$question = test_input($_POST["question"]);


$to = 'osavin@ukrgasbank.com, omazaiev@ukrgasbank.com, ovoloshyn@ukrgasbank.com';
//$from = "no-reply@ukrgasbank.com";
$from = "no-reply@ukrgasbank.com";
$subjectText = "Реєстрація учасника вебінару";
$subject = "=?UTF-8?B?".base64_encode($subjectText)."?=";

$headers   = array();
$headers[] = "MIME-Version: 1.0";
$headers[] = "Content-type: text/html; charset=UTF-8";
$headers[] = "From: Ukrgasbank <$from>";
$headers[] = "X-Mailer: PHP/".phpversion();

$message  = "<html><body>";
$message .= "<table rules=\"all\" style=\"border-color: #666;\" cellpadding=\"10\">";
$message .=    "<tr>";
$message .=       "<td><strong>Ім'я':</strong></td><td>". $name ."</td>";
$message .=    "</tr>";
$message .=    "<tr>";
$message .=       "<td><strong> Прізвище:</strong></td><td>". $lastname ."</td>";
$message .=    "</tr>";
$message .=    "<tr>";
$message .=       "<td><strong> Посада:</strong></td><td>". $position ."</td>";
$message .=    "</tr>";
$message .=    "<tr>";
$message .=       "<td><strong> Місто:</strong></td><td>". $city ."</td>";
$message .=    "</tr>";
$message .=    "<tr>";
$message .=       "<td><strong>Назва підприємства:</strong></td><td>". $industry ."</td>";
$message .=    "</tr>";
$message .=    "<tr>";
$message .=       "<td><strong>Email:</strong></td><td>". $email ."</td>";
$message .=    "</tr>";
$message .=    "<tr>";
$message .=       "<td><strong>Чи є у Вашого підприємства потреба:</strong></td><td>". $need ."</td>";
$message .=    "</tr>";
$message .=    "<tr>";
$message .=       "<td><strong>Вкажіть питання/теми:</strong></td><td>". $question ."</td>";
$message .=    "</tr>";
$message .= "</table";
$message .= "</body></html>";

$retval = mail($to, $subject, $message, implode("\r\n", $headers));

exit;

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);

  return $data;
}
