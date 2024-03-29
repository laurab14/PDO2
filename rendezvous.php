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
                <div class="col-3 pt-3 pl-5">
                    <a class="font-weight-bold " href="ajout-rendezvous.php"><button type="button" class="btn btn-info ajoutPatient ">Nouveau Rendez-vous</button></a>
                </div>
                <div class="col-6 pt-3">
                    <h1 class="text-center text-white font-weight-bold ">Rendez-vous</h1>
                </div>
                <div class="col-3 pt-3 text-right pr-5">
                    <a class="font-weight-bold" href="liste-rendezvous.php"><button type="button" class="btn btn-info ajoutPatient">Retour</button></a> 
                </div>

            </div>
        </div>

    </div>
    <?php
    // creation de l'objet "$bdd" = connexion base de donnée //////////////////////////////////////////////////
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=hospitalE2N;charset=utf8', 'pdo', 'pdo');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php
// fin de connexion base de donnée //////////////////////////////////////////////////
            $rdvInfo = $bdd->prepare("SELECT appointments.idPatients, patients.lastname,patients.firstname, patients.birthdate,patients.phone, patients.mail, appointments.dateHour FROM `appointments` INNER JOIN `patients` ON appointments.idPatients = patients.id WHERE appointments.id = :id");
            $rdvInfo->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
            $rdvInfo->execute();

            while ($donnees = $rdvInfo->fetch()) {
                ?>
                <div class="col-4 pt-4 mx-auto">
                    <div class="card mx-auto" style="width: 18rem;">
                        <div class="card-header text-center font-weight-bold">
                            Numéro de dossier <?= $_GET['id']; ?>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Nom : <?= $donnees['lastname']; ?></li>
                            <li class="list-group-item">Prénom : <?= $donnees['firstname']; ?></li>
                            <li class="list-group-item">Date de naissance : <?= $donnees['birthdate']; ?></li>
                            <li class="list-group-item">Date et Heure du RDV : <?= $donnees['dateHour']; ?></li>     
                            <p class="text-center font-weight-bold ">Contact</p>
                            <li class="list-group-item">Téléphone : <?= $donnees['phone']; ?></li>     
                            <li class="list-group-item">Mail : <?= $donnees['mail']; ?></li>     
                            <a href="modification-rendezvous.php?id=<?= $_GET['id'] ?>"><div class="bg-info text-center"><button class="button">Modifier RDV</button></div></a>
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
