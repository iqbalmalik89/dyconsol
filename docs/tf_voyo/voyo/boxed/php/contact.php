
<?php


if(!$_POST) exit();

// Enter your email address below.
// Example $to_address = "bruce.wayne@yourdomain.com";
$to_address = "your_email_address@domain.com"; 


$name = $_POST['name'];
$email = $_POST['email'];
$comment = $_POST['message'];


// Also, you can change the value of the $subject variable to whatever you like
$subject = "$name has contacted you via your Website";


// Message Content
$body = "You have been contacted by $name." . "\r\n" . "\r\n";
$content = $comment . "\r\n" . "\r\n";
$reply = "You can contact $name at: $email.";


$message = wordwrap($body . $content . $reply, 70);


// Headers
$headers .= "From: $name " . "\r\n";
$headers .= "Reply-To: $email" . "\r\n";
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8" . "\r\n";
$headers .= "Content-Transfer-Encoding: quoted-printable" . "\r\n";


// Please ensure that PHP mail() function is correctly configured on your server.
if ( mail($to_address, $subject, $message, $headers) ) {
	$result = array ('response'=>'success');
} else {
	$result = array ('response'=>'error');
}

echo json_encode($result);



?>
