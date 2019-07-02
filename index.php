<!DOCTYPE html>
<html lang="fr">
<?php
include_once 'template/head.php';
?>
<body>
<?php
include_once 'template/navbar.php';
?>
<button type="button" class="btn btn-outline-success"><a href="ajout-patient.php">Ajout patient</a></button> 
<?php
include_once 'template/cdn.php';
?>

</body>
</html>







<?php 
try
{
	$bdd = new PDO('mysql:host=localhost;hospitalE2N=test;charset=utf8', 'pdo', 'pdo');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

$lastName = $_POST['lastName'];
$firstName = $_POST['firstName'];
$birthDate = $_POST['birthDate'];
$phone = $_POST['phone'];
$mail = $_POST['mail'];
$bdd->exec('INSERT INTO `patients`(lastname, firstname, birthdate, phone, mail) VALUES($lastName, $firstName, $birthDate, $phone, $mail)');

?>