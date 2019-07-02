
<!DOCTYPE html>
<html lang="fr">
<?php
include_once 'template/head.php';
?>
<body>
<?php
include_once 'template/navbar.php';
?>
    <form action="liste-patient.php" method="POST">
    <p>Insciption nouveau patient : </p>
    <ul>
    <li><label for="lastName">Nom :<input type="text" name="lastName" /></label></li>
    <li><label for="firstName">Prénom : <input type="text" name="firstName" /></label></li>
    <li><label for="birthDate">Date de naissance : <input type="date" name="birthDate" /></label></li>
    <li><label for="phone">Télephone : <input type="text" name="phone" /></label></li>
    <li><label for="mail">Adresse mail : <input type="mail" name="mail" /></label></li>
    </ul>
    <button type="submit">Valider</button>
    </form>
    <?php
include_once 'template/cdn.php';
?>
</body>
</html>