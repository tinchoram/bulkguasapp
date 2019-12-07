<?php  


$to      = $email; // Send email to our user
$subject = 'BulkGuasapp | User Activation'; // Give the email a subject 
$message = '
 
Thanks for signing up!
Your account has been created, you can login after you have activated your account by pressing the url below.
 
------------------------
Username: '.$user.'
------------------------
 
Please click this link to activate your account:
http://tinchoram.com/bulkguasapp/verify.php?email='.$email.'&hash='.$hash.' '."\r\n"; // Our message above including the link
                     
$headers = 'From:noreply@tinchoram.com' . "\r\n"; // Set from headers
//mail($to, $subject, $message, $headers); // Send our email


//error_log("voy a enviar: ".$to." ".$subject." ".$headers." ".$hash, 3, "my-errors.log");

if ( mail($to, $subject, $message, $headers)) 
{
	$message = 'Usuario Creado Correctamente, se envio un correo para activacion!';
}
else 
{
	echo "No se pudo enviar el mensaje, contacte con tinchoram.com";
}	


?>