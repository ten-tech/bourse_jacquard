<?php
include_once("dbconfiguration.php");
if (isset($_POST['genre'], $_POST['nom'], $_POST['prenom'], $_POST['motDePasse'], $_POST['motDePasseConfirm'])) {
    /* Variable de récupération de données */
    $civilite   = htmlspecialchars($_POST['genre']);
    $nom	    = htmlspecialchars($_POST['nom']);
    $prenom     = htmlspecialchars($_POST['prenom']);
    $mail       = htmlspecialchars($_POST['email']);
    $mdp	    = htmlspecialchars($_POST['motDePasse']);
    $mdpConfirm = htmlspecialchars($_POST['motDePasseConfirm']);
    // Procédure de verification d'une éventuelle existance d'utilisateur par mail.
    $check_email = $pdoConnection->prepare('SELECT count(*) AS email_checked FROM conseiller WHERE email = :mail');
    $check_email->execute([':mail' => $mail]);
    $advisor_email_exists = $check_email->fetchObject();
    // On verifie par cette fonction si la procedure de vérification d'éventuelle existance d'utilisateur a abouti ou pas.
    if ($advisor_email_exists->email_checked > 0) {
        echo "<p id='user_exists'> J'ai déjà une personne nommée : <strong>$prenom "." $nom</strong> dans ma base de données. <br>
        Je suis sûre à 99,99% que c'est vous,<bold> $civilite "." $nom</bold> ! <br> Je suis heureux de vous revoir
         parmi nous.<br> Pour vous connecter, <a href=\"loginPerson.php\">suivez donc ce lien</a>.  </p>";
    }
    else{
      /* On vérifie si les variables ne sont pas vides et si les mots de passe inssérés sont identiques. */
      if ($civilite != NULL && $nom != NULL && $prenom != NULL && $mdp != NULL && $mdpConfirm != NULL && $mdp == $mdpConfirm) {
          /* On paramétre Le "cost" à 12.*/
          $optionsCost = ['cost' => 12];
          /* Hachage du mot de passe */
          $mdpHash = password_hash($mdpConfirm, PASSWORD_BCRYPT, $optionsCost);
          /* Variable sql d'insertion */
          $sqlInsertion = "INSERT INTO conseiller VALUES(NULL, :civilite, UPPER(:nom), :prenom, :mail, :mdpHash)";
          /* Préparation à L 'insertion de données dans La table conseiller */
          $resultat = $pdoConnection->prepare($sqlInsertion);
          $resultat->bindValue(':civilite', $civilite, PDO::PARAM_STR);
          $resultat->bindValue(':nom', $nom, PDO::PARAM_STR);
          $resultat->bindValue(':prenom', $prenom, PDO::PARAM_STR);
          $resultat->bindValue(':mail', $mail, PDO::PARAM_STR);
          $resultat->bindValue(':mdpHash', $mdpHash, PDO::PARAM_STR);
          // Cet execution n'est pas pris en compte.
          $execution = $resultat->execute();
          // Si l'insertion a été faite, on affiche un message de succès sinon on affiche un message d'erreur par la fonction suivante.
          if ($execution != 0) {
            // On fait une redirection directement vers la page e connexion.
            header('location: loginPerson.php');
          }
          else {
              echo "<p class='erreur'>Impossible de vous enregistrer pour le moment. Veuillez réessayer ultérieurement.</p>";
          }
      }
      else {
          echo "<p id=\"globalerror\"> Oups !! Il est nécessaire de remplir tous les champs. <br> De plus, assurez-vous que les mots de passe soient compatibles.</p>";
      }
    }
}

?>
