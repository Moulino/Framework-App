<?php

$messageTxt = "Bonjour $name,\n\n";
$messageTxt .= "Nous venons de vous créer un compte sur le site F.C.H. Sablières Capoulade.\n\n";
$messageTxt .= "Voici vos informations de connexion : \n";
$messageTxt .= "\tIdentifiant : $user_id\n";
$messageTxt .= "\tMot de passe : $password\n\n";
$messageTxt .= "Le mot de passe ci-dessus a été généré de manière aléatoire.";
$messageTxt .= "Nous vous invitons fortement à le modifier, une fois connecté sur le site internet.\n\n";
$messageTxt .= "Bonne navigation !\n\n";
$messageTxt .= "Cordialement.\n\n";


$messageHtml = "<html><body>";
$messageHtml .= "<p>";
$messageHtml .= "Bonjour $name,<br /><br />";
$messageHtml .= "Nous venons de vous créer un compte sur le <a href='http://fch-capoulade.fr'>site F.C.H. Sablières Capoulade</a>.<br /><br />";
$messageHtml .= "</p>";
$messageHtml .= "<span>Voici vos informations de connexion : </span>";
$messageHtml .= "<ul>";
$messageHtml .= "<li>Identifiant : $user_id</li>";
$messageHtml .= "<li>Mot de passe : $password</li>";
$messageHtml .= "</ul>";
$messageHtml .= "<p>Le mot de passe ci-dessus a été généré de manière aléatoire.";
$messageHtml .= "<p>Nous vous invitons fortement à le modifier, une fois connecté sur le site internet.</p>";
$messageHtml .= "<p>Bonne navigation</p>";
$messageHtml .= "<p>Cordialement.</p>";

$message = "\n--$boundary\n";
$message .= "Content-Type: text/plain; charset=UTF-8\n";
$message .= "Content-Transfer-Encoding: quoted-printable\n\n";
$message .= "$messageTxt\n\n";
$message .= "--$boundary\n";
$message .= "Content-Type: text/html; charset=UTF-8\n";
$message .= "Content-Transfer-Encoding: quoted-printable\n\n";
$message .= "$messageHtml\n\n";
$message .= "--$boundary--\n";

echo $message;
?>