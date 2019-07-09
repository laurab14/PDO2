<?php
// creation de l'objet "$bdd" = connexion base de donnée //////////////////////////////////////////////////
try {
    $bdd = new PDO('mysql:host=localhost;dbname=hospitalE2N;charset=utf8', 'pdo', 'pdo');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// fin de connexion base de donnée //////////////////////////////////////////////////
$listeRDV = $bdd->prepare("SELECT appointments.idPatients, patients.lastname,patients.firstname, patients.birthdate, appointments.dateHour, appointments.id FROM `appointments` INNER JOIN `patients` ON appointments.idPatients = patients.id");
$listeRDV->execute();
if (isset($_GET['deleteId'])) {
    $deleteRDV = $bdd->prepare("DELETE FROM appointments WHERE id = :id");
    $deleteRDV->bindValue(':id', $_GET['deleteId'], PDO::PARAM_INT);
    if ($deleteRDV->execute()) {
        header('Location: liste-rendezvous.php');
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
        <div class="container-fluid">
            <div class="row pt-4">
                <div class="col-md-3 col-sm-12 pt-3 pl-5">
                    <a class="font-weight-bold " href="ajout-rendezvous.php"><button type="button" class="btn btn-info ajoutPatient ">Nouveau Rendez-vous</button></a>
                </div>
                <div class="col-md-6 col-sm-12 pt-3">
                    <h1 class="text-center text-white font-weight-bold ">Liste des rendez-vous</h1>
                </div>
                <div class="col-md-3 col-sm-12 pt-3 text-right pr-5">
                    <a class="font-weight-bold" href="index.php"><button type="button" class="btn btn-info ajoutPatient">Retour</button></a> 
                </div>

            </div>
        </div> 
        <div class="container-fluid">
            <div class="row">
                <?php
                while ($donnees = $listeRDV->fetch()) {
                    ?>
                    <div class="col-md-4 col-sm-12 pt-4">
                        <div class="card mx-auto" style="width: 18rem;">
                            <div class="card-header text-center font-weight-bold">
                                Numéro de dossier <?= $donnees['idPatients']; ?>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Nom : <?= $donnees['lastname']; ?></li>
                                <li class="list-group-item">Prénom : <?= $donnees['firstname']; ?></li>
                                <li class="list-group-item">Date et Heure du RDV : <?= $donnees['dateHour']; ?></li> 
                                <a href="rendezvous.php?id=<?= $donnees['id'] ?>"><div class="bg-info text-center"><button class="button">Voir plus</button></div></a>
                                <a href="liste-rendezvous.php?deleteId=<?= $donnees['id'] ?>"><div class="bg-danger text-center"><button class="button">Supprimer RDV</button></div></a>
                            </ul>
                        </div>
                        <p></p>
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
