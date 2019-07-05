<?php
// creation de l'objet "$bdd" = connexion base de donnée //////////////////////////////////////////////////
try {
    $bdd = new PDO('mysql:host=localhost;dbname=hospitalE2N;charset=utf8', 'pdo', 'pdo');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$id = $_GET['id'];
// fin de connexion base de donnée //////////////////////////////////////////////////
if (isset($_POST['modify'])) {
//je crée des variables pour récupérer la valeur des POST
                $lastName = $_POST['lastName'];
                $firstName = $_POST['firstName'];
                $birthDate = $_POST['birthDate'];
                $phone = $_POST['phone'];
                $mail = $_POST['mail'];
                
                $bdd_modifs = $bdd->prepare("UPDATE patients SET lastname = :lastname, firstname = :firstname, birthdate = :birthdate, phone = :phone, mail = :mail WHERE id = :id");
            $bdd_modifs->bindValue(':id', $id, PDO::PARAM_STR);
            $bdd_modifs->bindValue(':lastname', $lastName, PDO::PARAM_STR);
            $bdd_modifs->bindValue(':firstname', $firstName, PDO::PARAM_STR);
            $bdd_modifs->bindValue(':birthdate', $birthDate, PDO::PARAM_STR);
            $bdd_modifs->bindValue(':phone', $phone, PDO::PARAM_STR);
            $bdd_modifs->bindValue(':mail', $mail, PDO::PARAM_STR);
            if($bdd_modifs->execute()){
                header('Location: profil-patient.php?id=' . $id);
            }
                                }
?>
<?php
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
            <div class="row justify-content-end pt-4">
                <div class="col-2">
                    <button type="button" class="btn btn-info ajoutPatient"><a class="font-weight-bold" href="profil-patient.php?id=<?= $_GET['id'] ?>">Retour</a></button> 
                </div>
            </div>
        </div> 
        <div class="container-fluid">
        <div class="row">
             <?php
            while ($donnees = $profilRequest->fetch()) {
                ?>
            <div class="col-4 mx-auto pt-4">
                <div class="card mx-auto" style="width: 18rem;">
                    <form action="modification-patient.php?id=<?= $id ?>" method="POST">
                    <div class="card-header text-center font-weight-bold">
                        <p>Modification patient<br>Numéro de dossier <?= $id; ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><label for="lastName">Nom : <input type="text" name="lastName" value="<?= $donnees['lastname']; ?>"/></label></li>
                        <li class="list-group-item"><label for="firstName">Prénom : <input type="text" name="firstName" value="<?= $donnees['firstname']; ?>"/></label></li>
                        <li class="list-group-item"><label for="birthDate">Date de naissance : <input type="date" name="birthDate" value="<?= $donnees['birthdate']; ?>"/></label></li>
                        <li class="list-group-item"><label for="phone">Télephone : <input type="text" name="phone" value="<?=$donnees['phone'];?>"/></label></li>
                        <li class="list-group-item"><label for="mail">Adresse mail : <input type="mail" name="mail" value="<?= $donnees['mail']; ?>"/></label></li>
                    </ul>
                    <button  class="bg-info" type="submit" name="modify">Valider</button>
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
