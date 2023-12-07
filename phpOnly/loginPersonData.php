<?php
    /* ************************* BACKEND DU FORMULAIRE DE CONNEXION DES CONSEILLER.E.S ********************* */
    // On ajoute le fichier de configuration de la base de données
    require_once("dbconfiguration.php");

    if(isset($_POST['seConnecter'])){
        // Sin le nom d'utilisateur et son mot de passe ne sont pas vides, on supprime les espaces vides.
        $advisor  = !empty($_POST['identifiant']) ? trim($_POST['identifiant']) : null;
        $mot2pass = !empty($_POST['motDePasse']) ? trim($_POST['motDePasse']) : null;
        //On verifie si l'adresse mail existe dans la base de données.
        $verification = $pdoConnection->query("SELECT passWord AS motDePasse FROM conseiller WHERE email = '" . $advisor . "'");
        // On lie la ligne
        $user = $verification->fetch(PDO::FETCH_ASSOC);
        // Si la $user est faut alors on affiche un message comme quoi pas de user de ce type.
        if(!isset($user['motDePasse']) || $user['motDePasse']  == ''){
            echo '<p class="advisor_checker"> Oups ! Ce personnel m\'est inconnu. </p>';
        }
        else {
            //Sinon on compare et on decripte le mot de passe
            $validPassword = password_verify($_POST['motDePasse'], $user['motDePasse']);
            // Si le mot de passe indiqué est bon alors on passe à la page d'accueil.
            if($validPassword != 0){
                // On ouvre donc une session pour ce ou cette conseiller.e
                session_start();
                $_SESSION['nom'] = $advisor;
                header("Location: index4.php");
                exit;
            }
            else {
                echo '<p id="globalerror"> Mot de passe invalide </p>';
            }
        }
    }
?>