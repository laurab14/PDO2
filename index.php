<!DOCTYPE html>
<html lang="fr">
<?php
include_once 'template/head.php';
?>
<body>
<?php
include_once 'template/navbar.php';
?>
    <div class="container-fluid">
        <div class="row justify-content-end pt-4">
        <div class="col-2">
            <button type="button" class="btn btn-info ajoutPatient"><a class="font-weight-bold" href="ajout-patient.php">Ajout patient</a></button> 
    </div>
    </div>
    </div>
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