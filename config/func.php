<?php
function send_mail($to, $subject, $message){
$header = "From: gpfe@univ-guelma.dz"; // must be a genuine address
//send the email
$mail_sent = mail($to, $subject, $message, $header);
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 

return $mail_sent;
}
?>