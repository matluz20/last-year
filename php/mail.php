<?php


$to = 'matondoluzolo20@gmail.com';
$subject = 'Bienvenue sur Choose me !';
$message = 'Bonjour [nom du client],


Nous sommes ravis de vous accueillir sur notre serveur ! Votre inscription a été prise en compte et nous sommes impatients de vous accompagner dans votre utilisation de nos services.

Votre identifiant de connexion est : .

Nhésitez pas à nous contacter si vous avez des questions ou des problèmes lors de votre utilisation de notre serveur.

Encore une fois, merci de votre confiance et à bientôt !

Cordialement,
Ls ';


$headers = "From: ne.pas.repondre.choose.me@gmail.com\r\n";
$headers .= "Reply-To: matondoluzolo20@gmail.com\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";



$mail_sent = mail($to, $subject, $message, $headers);

if ($mail_sent) {
  echo "Mail envoyé avec succès !";
} else {
  echo "Erreur lors de l'envoi du mail.";
}


?>


<!-- <form action="php/mail.php" method="POST">
    <button class='btn-rech' type="submit">Mail</button>
	</form> -->

