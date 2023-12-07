<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../styles/inscriptionPersonnel.css" media="screen" type="text/css" />
    <link rel="icon" type="image/png" sizes="36x36" href="../icones/bank.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title> Personnel - connection </title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form class="connectionForm" action="" method="POST">
                    <h1> Authentification || Conseiller(e)</h1>
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
                    <section class="loginSection">
                        <div id="divClass">
                            <label for="Mot de passe">
                                <strong> Insérez votre identifiant</strong>
                            </label>
                            <input type="text" name="identifiant" id="inputID" placeholder="btssnir.bourse@gmail.com">
                        </div>
                        <div id="divClass">
                            <label for="Confirmation">
                                <strong> Insérez votre mot de passe </strong>
                            </label>
                            <input type="password" name="motDePasse" id="inputID" placeholder="*********">
                        </div>
                    </section>
                    <input type="submit" name="seConnecter" value="Se connecter" id="submit">
                    <section class="NewPerso">
                        <p>
                            Mot de passe oublié ? Pas de panique ! <br> <a href="" id="link-a"> Cliquez ici pour en
                                créer
                                un
                                autre</a>.
                        </p>

                        <p>N'avez-vous pas un compte ? <br> <a href="inscriptionPersonnel.php" id="link-a"> Cliquez ici
                                pour
                                vous
                                inscrire</a>.
                        </p>
                    </section>

                </form>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
// Pour afficher uen message pendant 7s
$(document).ready(function() {
    $('#user_exists').fadeIn('slow', function() {
        $('#user_exists').delay(7000).fadeOut();
    });
});

// Pour afficher un message d'echec pendant 5s
$(document).ready(function() {
    $('.erreur').fadeIn('slow', function() {
        $('.erreur').delay(5000).fadeOut();
    });
});

// Erreur de champs vide ou de frappe
$(document).ready(function() {
    $('#globalerror').fadeIn('slow', function() {
        $('#globalerror').fadeOut(6500);
    });
});
</script>

</html>