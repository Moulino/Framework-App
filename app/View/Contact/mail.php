<?php 

$messageTxt = "Un client vous a envoyé un mail à travers le site internet.\n\n";
$messageTxt .= "Nom : $firstname $lastname\n";
$messageTxt .= "Téléphone : $telephone\n\n";
$messageTxt .= "Objet : $subject\n\n";
$messageTxt .= "$message\n";
$messageTxt = quoted_printable_encode($messageTxt);

$messageHtml = "<html><head></head><body>";
$messageHtml .= "<b>Un client vous a envoyé un mail à travers le site internet.</b><br><br>";
$messageHtml .= "<u>Nom :</u> $firstname $lastname<br>";
$messageHtml .= "<u>Téléphone :</u> $telephone<br><br>";
$messageHtml .= "<u>Objet :</u> $subject<br><br>";
$messageHtml .= "<p>$message</p><br>";
$messageHtml = quoted_printable_encode($messageHtml);

$message = "\n--$boundary\n";
$message .="Content-Type: text/plain; charset=UTF-8\n";
$message .="Content-Transfer-Encoding: quoted-printable\n\n";
$message .="$messageTxt\n\n";
$message .="--$boundary\n";
$message .="Content-Type: text/html; charset=UTF-8\n";
$message .="Content-Transfer-Encoding: quoted-printable\n\n";
$message .="$messageHtml\n\n";
$message .="--$boundary--\n";

echo $message;
?>