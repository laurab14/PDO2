<?php
// creation de l'objet "$bdd" = connexion base de donnée //////////////////////////////////////////////////
try {
    $bdd = new PDO('mysql:host=localhost;dbname=hospitalE2N;charset=utf8', 'pdo', 'pdo');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_GET['deleteId'])) {
    $deletePatients = $bdd->prepare("DELETE FROM patients WHERE id = :id");
    $deletePatients->bindValue(':id', $_GET['deleteId'], PDO::PARAM_INT);
    if ($deletePatients->execute()) {
        header('Location: liste-patient.php');
    }
}
?>
<?php
if (isset($_GET['search']) AND ! empty($_GET['search'])) {
    $search = htmlspecialchars($_GET['search']);
    $searchBdd = $bdd->prepare("SELECT id, firstname, lastname FROM `patients` WHERE id LIKE :search ORDER BY lastname");
    $searchBdd->bindValue(':search', $search, PDO::PARAM_INT);
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
                        <input class="form-control mr-sm-2" type="search" name="search"placeholder="Search" aria-label="Search">
                        <button class="btn btn-info  my-2 my-sm-0 font-weight-bold" type="submit" name="btnSearch">Search</button>
                    </form>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-info ajoutPatient"><a class="font-weight-bold" href="ajout-patient.php">Ajout patient</a></button> 
                </div>
            </div>
            <div class="row justify-content-end pt-4">
                <div class="col-2">
                    <button type="button" class="btn btn-info ajoutPatient"><a class="font-weight-bold" href="liste-patient.php">Retour</a></button> 
                </div>
            </div>
            <h1 class="text-center text-white font-weight-bold pt-4">Liste de vos patients</h1>
            <div class="container-fluid">
                <div class="row">
                    <?php
                    $page = $_GET['page'];
// Partie "Requête"
                    $limite = 6;
                    /* On calcule donc le numéro du premier enregistrement */
                    $debut = ($page - 1) * $limite;

                    $reponse = $bdd->prepare("SELECT id, firstname, lastname FROM `patients` LIMIT :limite");
                    $reponse->bindValue(':limite', $limite, PDO::PARAM_INT);
     
                    $reponse->execute();
                    if (!isset($_GET['search']) AND empty($_GET['search'])) {
                        while ($donnees = $reponse->fetch()) {
                            $compteur = 0;
                            if ($compteur >= $limite) {
                                break;
                            }
                            ?>
                            <div class="col-4 pt-4 mx-auto">
                                <div class="card mx-auto" style="width: 18rem;">
                                    <div class="card-header text-center font-weight-bold">
                                        Numéro de dossier <?= $donnees['id']; ?>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Nom : <?= $donnees['lastname']; ?></li>
                                        <li class="list-group-item">Prénom : <?= $donnees['firstname']; ?></li>
                                    </ul>
                                    <button class="bg-info"><a href="profil-patient.php?id=<?= $donnees['id'] ?>">Profil patient</a></button>
                                    <button class="bg-danger"><a href="liste-patient.php?deleteId=<?= $donnees['id'] ?>">Supprimer dossier</a></button>
                                </div>
                                <p></p>
                            </div>
                            <?php
                            // C'est là qu'on affiche les données  :)
                            $compteur++;
                        }
                        ?> <a href = "?page=<?php echo $page - 1; ?>">Page précédente</a>
                        —
                        <a href = "?page=<?php echo $page + 1; ?>">Page suivante</a>
                        <?php
                    } else {
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
                                </ul>
                                <button class="bg-info"><a href="profil-patient.php?id=<?= $donnees['id'] ?>">Profil patient</a></button>
                                <button class="bg-danger"><a href="liste-patient.php?deleteId=<?= $donnees['id'] ?>">Supprimer dossier</a></button>
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
