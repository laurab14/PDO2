<?php
// creation de l'objet "$bdd" = connexion base de donnée //////////////////////////////////////////////////
try {
    $bdd = new PDO('mysql:host=localhost;dbname=hospitalE2N;charset=utf8', 'pdo', 'pdo');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$id = $_GET['id'];
// fin de connexion base de donnée //////////////////////////////////////////////////
if (isset($_POST['modifyRDV'])) {
//je crée des variables pour récupérer la valeur des POST
    $dateHour = $_POST['dateHour'];
    $idPatients = $_POST['idPatients'];

    $bdd_modifs = $bdd->prepare("UPDATE appointments SET dateHour = :dateHour, idPatients = :idPatients WHERE id = :id");
    $bdd_modifs->bindValue(':id', $id, PDO::PARAM_STR);
    $bdd_modifs->bindValue(':dateHour', $dateHour, PDO::PARAM_STR);
    $bdd_modifs->bindValue(':idPatients', $idPatients, PDO::PARAM_STR);

    if ($bdd_modifs->execute()) {
        header('Location: liste-rendezvous.php?id=' . $id);
    }
}
?>
<?php
// Préparation de la requête avec le marquer nominatif :id
$rdvRequest = $bdd->prepare("SELECT * FROM `appointments` WHERE id= :id");
// attribution de la valeur de :id qui sera récupéré par un GET via les param d'URL ex. "...?id="
$rdvRequest->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
$rdvRequest->execute();
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
        <div class="container-fluid">
            <div class="row justify-content-end pt-4">
                <div class="col-2">
                    <a class="font-weight-bold" href="rendezvous.php?id=<?= $_GET['id'] ?>"><button type="button" class="btn btn-info ajoutPatient">Retour</button></a> 
                </div>
            </div>
        </div> 
        <div class="container-fluid">
            <div class="row">
                <?php
                while ($donnees = $rdvRequest->fetch()) {
                    ?>
                    <div class="col-4 mx-auto pt-4">
                        <div class="card mx-auto" style="width: 18rem;">
                            <form action="modification-rendezvous.php?id=<?= $id ?>" method="POST">
                                <div class="card-header text-center font-weight-bold">
                                    <p>Modification patient<br>Numéro de dossier <?= $id; ?></p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><label for="dateHour">Date et heure : <input type="text" name="dateHour" value="<?= $donnees['dateHour']; ?>"/></label></li>
                                    <li class="list-group-item"><label for="idPatients">Numéro patient : <input type="text" name="idPatients" value="<?= $donnees['idPatients']; ?>"/></label></li>
                                    <button  class="bg-info" type="submit" name="modifyRDV">Valider</button>
                                </ul>
                            </form>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        include_once 'template/cdn.php';
        ?>

    </body>
</html>
