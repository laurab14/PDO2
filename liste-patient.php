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
// fin de connexion base de donnée //////////////////////////////////////////////////
// On test sur le bouton ajout a été cliqué
if (isset($_GET["btnSearch"]) AND $_GET["btnSearch"] == "Rechercher") {
    $_GET["search"] = htmlspecialchars($_GET["search"]); //pour sécuriser le formulaire contre les failles html
    $search = $_GET["search"];
 $search = trim($search);
 $search = strip_tags($search);  
}

$id = $_GET['search'];
if (isset($search)) {
    $search = strtolower($search);
    $select_search = $bdd->prepare("SELECT id, lastname, firstname, birthdate, phone, mail  FROM patients WHERE  id LIKE :search OR lastname LIKE :search OR firstname LIKE :search OR birthdate LIKE :search OR phone LIKE :search OR mail LIKE :search");
    $select_search->bindValue(':search', $_GET['search']);
     $select_search->execute();
    $select_searchFetch = $select_search->fetchAll(PDO::FETCH_ASSOC);
    var_dump($select_searchFetch);
   foreach($select_searchFetch as $key=>$value):?>
<a href="profil-patient.php?id=<?= $value['id'] ?>"><?= $value['lastname'].' '.$value['firstname'] ?></a>
<?php
   endforeach;
}
//       header('Location: profil-patient.php$id=' .$id);

//    $message = "Vous devez entrer votre requete dans la barre de recherche";

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
        </div>
        <h1 class="text-center text-white font-weight-bold pt-4">Liste de vos patients</h1>
        <div class="container-fluid">
        <div class="row">
        <?php
        
// fin de connexion base de donnée //////////////////////////////////////////////////
        $reponse = $bdd->query("SELECT id, firstname, lastname FROM `patients`");
        while ($donnees = $reponse->fetch()) {
                    ?>
            <div class="col-4 pt-4">
        <div class="card mx-auto" style="width: 18rem;">
                <div class="card-header text-center font-weight-bold">
                    Numéro de dossier <?=$donnees['id']; ?>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nom : <?= $donnees['lastname']; ?></li>
                    <li class="list-group-item">Prénom : <?= $donnees['firstname']; ?></li>
                </ul>
            <button class="bg-info"><a href="profil-patient.php?id=<?= $donnees['id']?>">Profil patient</a></button>
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
