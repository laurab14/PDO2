<?php
// creation de l'objet "$bdd" = connexion base de donnée //////////////////////////////////////////////////
try {
    $bdd = new PDO('mysql:host=localhost;dbname=hospitalE2N;charset=utf8', 'pdo', 'pdo');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
// fin de connexion base de donnée //////////////////////////////////////////////////
// On test sur le bouton ajout a été cliqué
if (isset($_POST['ajout'])) {
//je crée des variables pour récupérer la valeur des POST
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $birthDate = $_POST['birthDate'];
    $phone = $_POST['phone'];
    $mail = $_POST['mail'];

    // on prepare la requete $addRequest à l'aide de marqueur nominatif de la forme :marqeur
    $addRequest = $bdd->prepare("INSERT INTO `patients` (lastname, firstname, birthdate, phone, mail) VALUES (:lastname, :firstname, :birthdate, :phone, :mail)");

    // Nous attribuons les valeurs respectives aux marqueurs nominatifs via un bindValue(NOM DU MARQUEUR, VALEUR, TYPE)
    // ex. $addRequest->bindValue(':lastname', $lastName, PDO::PARAM_STR);
    $addRequest->bindValue(':lastname', $lastName, PDO::PARAM_STR);
    $addRequest->bindValue(':firstname', $firstName, PDO::PARAM_STR);
    $addRequest->bindValue(':birthdate', $birthDate, PDO::PARAM_STR);
    $addRequest->bindValue(':phone', $phone, PDO::PARAM_STR);
    $addRequest->bindValue(':mail', $mail, PDO::PARAM_STR);
    // on execute notre requete preparee
    if ($addRequest->execute()) {
        header('Location: liste-patient.php');
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<?php
include_once 'template/head.php';
?>
    <body>
    <?php
    include_once 'template/navbar.php';
    ?>
        <div class="col-4 mx-auto pt-4">
            <div class="card mx-auto" style="width: 18rem;">
        <form action="ajout-patient.php" method="POST">
            <div class="card-header text-center font-weight-bold">
                <p>Insciption nouveau patient : </p> 
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><label for="lastName">Nom :<input type="text" name="lastName" /></label></li>
                <li class="list-group-item"><label for="firstName">Prénom : <input type="text" name="firstName" /></label></li>
                <li class="list-group-item"><label for="birthDate">Date de naissance : <input type="date" name="birthDate" /></label></li>
                <li class="list-group-item"><label for="phone">Télephone : <input type="text" name="phone" /></label></li>
                <li class="list-group-item"><label for="mail">Adresse mail : <input type="mail" name="mail" /></label></li>
            </ul>
            <div class="align-content-right"><button class="bg-info" type="submit" name="ajout">Valider</button></div>
        </form>
    </div>
</div>
<?php
include_once 'template/cdn.php';
?>
    </body>
</html>
