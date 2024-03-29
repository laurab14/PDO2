<?php
// creation de l'objet "$bdd" = connexion base de donnée //////////////////////////////////////////////////
try {
    $bdd = new PDO('mysql:host=localhost;dbname=hospitalE2N;charset=utf8', 'pdo', 'pdo');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
<?php
setlocale(LC_TIME, "fr_FR.utf8","fra");
// Préparation de la requête avec le marquer nominatif :id
$profilRequest = $bdd->prepare("SELECT * FROM `patients` WHERE id= :id");
// attribution de la valeur de :id qui sera récupéré par un GET via les param d'URL ex. "...?id="
$profilRequest->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
$profilRequest->execute();
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
                <div class="col-3"></div>
                <div class="col-6 text-center"><h1 class="text-center text-white font-weight-bold">Profil patient</h1></div>
                <div class="col-3 text-right pr-5">
                    <a class="font-weight-bold" href="liste-patient.php"><button type="button" class="btn btn-info ajoutPatient">Retour</button></a>
                </div>
            </div>
        </div>  

        <div class="container-fluid">
        <div class="row pt-5">
            <?php
            while ($donnees = $profilRequest->fetch()) {
    ?>
                <div class="col-6 mx-auto">
                    <div class="card mx-auto" style="width: 22rem;">
                        <div class="card-header text-center font-weight-bold">
                            Numéro de dossier <?= $_GET['id']; ?>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Nom : <?= $donnees['lastname']; ?></li>
                            <li class="list-group-item">Prénom : <?= $donnees['firstname']; ?></li>
                            <li class="list-group-item">Date de naissance : <?= strftime('%d/%m/%Y',strtotime($donnees['birthdate'])); ?></li>
                            <li class="list-group-item">Téléphone : <?= $donnees['phone']; ?></li>
                            <li class="list-group-item">Mail : <?= $donnees['mail']; ?></li>
                            <a href="modification-patient.php?id=<?= $donnees['id'] ?>"><div class="bg-info text-center"><button class="button">Modifier</button></div></a>
                        </ul>
                    </div>
                </div>
                <?php
            }
            ?>
                         <?php
// fin de connexion base de donnée //////////////////////////////////////////////////
            $rdvInfo = $bdd->prepare("SELECT appointments.id, appointments.dateHour FROM `appointments` INNER JOIN `patients` ON appointments.idPatients = patients.id WHERE appointments.idPatients = :id");
            $rdvInfo->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
            $rdvInfo->execute();

      
while ($donnees = $rdvInfo->fetch()) {
    ?>
                <div class="col-4 pt-4 mx-auto">
                    <div class="card mx-auto" style="width: 18rem;">
                        <div class="card-header text-center font-weight-bold">
                            Numéro du RDV <?= $donnees['id']; ?>
                        </div>
                        <ul class="list-group list-group-flush">
                        
                            <li class="list-group-item">Date et Heure du RDV :  </li>
                            <li class="list-group-item">Le <?= ucfirst(strftime('%A %d %B %Y' .' à '. '%k:%M', strtotime($donnees['dateHour']))); ?></li>           
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
