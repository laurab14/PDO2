<?php
// creation de l'objet "$bdd" = connexion base de donnée //////////////////////////////////////////////////
try {
    $bdd = new PDO('mysql:host=localhost;dbname=hospitalE2N;charset=utf8', 'pdo', 'pdo');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_GET['deleteId'])) {
    $deletePatients = $bdd->prepare("DELETE FROM patients WHERE id = :id");
    $deletePatients->bindValue(':id', $_GET['deleteId'], PDO::PARAM_STR);
    if ($deletePatients->execute()) {
        header('Location: liste-patient.php');
    }
}
$page = (!empty($_GET['page']) ? $_GET['page'] : 1);
// Partie "Requête"
// On choisit le nombre de patients à afficher via $limite    
$limite = 6;

// On calcule le nombre total de patients
$requeteTotalPatients = $bdd->query("SELECT * FROM `patients`");
$nbPatients = count($requeteTotalPatients->fetchAll());

// On calcule donc le numéro du premier enregistrement
$debut = ($page - 1) * $limite;
$reponse = $bdd->prepare("SELECT id, firstname, lastname FROM `patients` LIMIT :limite OFFSET :debut");
$reponse->bindValue(':limite', $limite, PDO::PARAM_INT);
$reponse->bindValue('debut', $debut, PDO::PARAM_INT);
$reponse->execute();
?>
<?php
if (isset($_GET['search']) AND ! empty($_GET['search'])) {
    $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
// Partie "Requête"
// On choisit le nombre de patients à afficher via $limite    
    $limite = 6;

// On calcule le nombre total de patients
    $requeteTotalPatients = $bdd->query("SELECT * FROM `patients`");
    $nbPatients = count($requeteTotalPatients->fetchAll());

// On calcule donc le numéro du premier enregistrement
    $debut = ($page - 1) * $limite;
    $search = htmlspecialchars($_GET['search']);
    $searchBdd = $bdd->prepare("SELECT id, firstname, lastname FROM `patients` WHERE id LIKE :search OR firstname LIKE :search OR lastname LIKE :search ORDER BY lastname LIMIT :limite OFFSET :debut ");
    $searchBdd->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $searchBdd->bindValue(':limite', $limite, PDO::PARAM_INT);
    $searchBdd->bindValue('debut', $debut, PDO::PARAM_INT);
    $searchBdd->execute();
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
            <div class="row justify-content-end pt-4">
                <div class="col-4">
                    <form action="liste-patient.php" method="GET" class="form-inline justify-content-end">
                        <input class="form-control mr-sm-2" type="search" name="search"placeholder="Nom du patient" aria-label="Search">
                        <button class="btn btn-info  my-2 my-sm-0 font-weight-bold" type="submit" name="btnSearch">Recherche</button>
                    </form>
                </div>
                <div class="col-2">
                    <a class="font-weight-bold" href="ajout-patient.php"><button type="button" class="btn btn-info ajoutPatient">Ajout patient</button></a> 
                </div>
            </div>
            <div class="row justify-content-end pt-4">
                <div class="col-2">
                    <a class="font-weight-bold" href="liste-patient.php"><button type="button" class="btn btn-info ajoutPatient">Retour</button></a>
                </div>
            </div>
            <h1 class="text-center text-white font-weight-bold pt-4">Liste de vos patients</h1>
            <div class="container-fluid">
                <div class="row mx-auto"> 
                    <?php
                    if (!isset($_GET['search']) AND empty($_GET['search'])) { 
                        ?>
                    <div class = "col-4 mx-auto">
                        <?php
                        if ($_GET['page'] > 1) {
                            ?>
                                <div class="text-center"><a href = "?page=<?php echo $page - 1; ?>">
                                        <button class = "btn btn-info">Page précédente</button></a></div>
                                <?php
                            }
                            ?>
                        </div>
                            <?php
                            for ($pageIndex = 1; $pageIndex <= (ceil($nbPatients / $limite)); $pageIndex++) {
                                ?>
                        <a class="font-weight-bold pagination pr-4" href="liste-patient.php?page=<?= $pageIndex ?>"><?= $pageIndex ?></a>
                                <?php
                            }
                            ?>        
                        <?php
                        // Nous effectuons une condition pour afficher le bouton suivant
                        // On calcul le nombre de page grâce à la division du $nbPatients par $limite(limite de patients par pa                            //ge) avec le seil pour l'arrondir au nombre du dessus si il n'est pas un entier.
                        ?><div class = "col-4 mx-auto"><?php
                        if ($page < (ceil($nbPatients / $limite))) {
                            ?>

                                <div class="text-center"><a href = "?page=<?php echo $page + 1; ?>"><button class = "btn btn-info">Page suivante</button></a></div>
                                <?php
                            }
                            ?>
                        </div><?php
                        while ($donnees = $reponse->fetch()) {
                            ?>
                            <div class="col-4 pt-4 mx-auto">
                                <div class="card mx-auto" style="width: 18rem;">
                                    <div class="card-header text-center font-weight-bold">
                                        Numéro de dossier <?= $donnees['id']; ?> 
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Nom : <?= $donnees['lastname']; ?></li>
                                        <li class="list-group-item">Prénom : <?= $donnees['firstname']; ?></li>
                                        <a href="profil-patient.php?id=<?= $donnees['id'] ?>"><div class="bg-info text-center"><button class="button">Profil patient</button></div></a>
                                        <a href="liste-patient.php?deleteId=<?= $donnees['id'] ?>"><div class="bg-danger text-center"><button class="button">Supprimer dossier</button></div></a>
                                    </ul> 
                                </div>
                            </div>
                            <?php
                            // C'est là qu'on affiche les données  :)
                        }
                        ?> 
                        <?php
                    } else {
                        ?><div class = "col-4 mx-auto">
                        <?php
                        if ($_GET['page'] > 1) {
                            ?>
                                <div class="text-center"><a href = "?page=<?php echo $page - 1; ?>"><button class = "btn btn-info">Page précédente</button></a></div>
                                —
                                <?php
                            }
                            ?>
                        </div>
                        <div class="mx-auto">
                            <?php
                            for ($pageIndex = 1; $pageIndex <= (ceil($nbPatients / $limite)); $pageIndex++ ) {
                                ?>
                            <a class="font-weight-bold pagination" href="liste-patient.php?page=<?=$pageIndex?>"><?=$pageIndex?></a>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
// Nous effectuons une condition pour afficher le bouton suivant
// On calcul le nombre de page grâce à la division du $nbPatients par $limite(limite de patients par pa                            //ge) avec le seil pour l'arrondir au nombre du dessus si il n'est pas un entier.
                        ?><div class = "col-4 mx-auto"><?php
                        if ($page < (ceil($nbPatients / $limite))) {
                            ?>

                                <div class="text-center"><a href = "?page=<?php echo $page + 1; ?>"><button class = "btn btn-info">Page suivante</button></a></div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        while ($donnees = $searchBdd->fetch()) {
                            ?>
                            <div class = "col-4 pt-4 mx-auto">
                                <div class = "card mx-auto" style = "width: 18rem;">
                                    <div class = "card-header text-center font-weight-bold">
                                        Numéro de dossier <?= $donnees['id'];
                            ?>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Nom : <?= $donnees['lastname']; ?></li>
                                        <li class="list-group-item">Prénom : <?= $donnees['firstname']; ?></li>
                                        <a href="profil-patient.php?id=<?= $donnees['id'] ?>"><div class="bg-info text-center"><button class="button">Profil patient</button></div></a>
                                        <a href="liste-patient.php?deleteId=<?= $donnees['id'] ?>"><div class="bg-danger text-center"><button class="button">Supprimer dossier</button></div></a>
                                    </ul>
                                </div>
                            </div> 
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>
            <?php
            include_once 'template/cdn.php';
            ?>

    </body>
</html>
