<?php
// creation de l'objet "$bdd" = connexion base de donnée //////////////////////////////////////////////////
try {
    $bdd = new PDO('mysql:host=localhost;dbname=hospitalE2N;charset=utf8', 'pdo', 'pdo');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
// fin de connexion base de donnée //////////////////////////////////////////////////
// On test sur le bouton ajout a été cliqué
if (isset($_POST['ajoutRDV'])) {
//je crée des variables pour récupérer la valeur des POST
    $dateHour = $_POST['dateHour'];
    $idPatients = $_POST['idPatients'];
 
 
    // on prepare la requete $addRDV à l'aide de marqueur nominatif de la forme :marqeur
    $addRDV = $bdd->prepare("INSERT INTO `appointments` (dateHour, idPatients) VALUES (:dateHour, :idPatients)");

    // Nous attribuons les valeurs respectives aux marqueurs nominatifs via un bindValue(NOM DU MARQUEUR, VALEUR, TYPE)
    // ex. $addRDV->bindValue(':dateHour', $dateHour, PDO::PARAM_STR);
    $addRDV->bindValue(':dateHour', $dateHour, PDO::PARAM_STR);
    $addRDV->bindValue(':idPatients', $idPatients, PDO::PARAM_INT);
    $addRDV->execute();
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
                <form action="ajout-rendezvous.php" method="POST">
                    <div class="card-header text-center font-weight-bold">
                        <p>Nouveau RDV : </p> 
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><label for="idPatients">Numéro patient : <input type="text" name="idPatients" /></label></li>
                        <li class="list-group-item"><label for="dateHour">Date et heure du RDV :<input type="text" name="dateHour" value="2019-01-01 13:00:00" /></label></li>
                        <button type="submit" name="ajoutRDV" class="button bg-info" >Valider</button>
                    </ul>
                    
                </form>
            </div>
        </div>
        <?php
        include_once 'template/cdn.php';
        ?>
    </body>
</html>
