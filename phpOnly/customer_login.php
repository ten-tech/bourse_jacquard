<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../styles/nouveauClient.css" media="screen" type="text/css" />
    <link rel="icon" type="image/png" sizes="36x36" href="../icones/bank.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title> Client - authentification </title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form class="connectionForm" action="customer_login.php" method="POST">
                    <h1> Je me connecte </h1>
                    <?php
                        /*
                        ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                        ************************* BACKEND DU FORMULAIRE DE CONNEXION DES CLIENTS *********************
                        ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                        */
                        // On ajoute le fichier de configuration de la base de données
                        require_once "dbconfiguration.php";

                        if(isset($_POST['seConnecter'])){
                            // Sin le nom d'utilisateur et son mot de passe ne sont pas vides, on supprime les espaces vides.
                            $customer  = !empty($_POST['identifiant']) ? trim($_POST['identifiant']) : null;
                            $mot2pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
                            //On verifie si l'adresse mail existe dans la base de données.
                            $verification = $pdoConnection->query("SELECT * FROM client WHERE email_cli = '".$customer."'");
                            $user = $verification->fetch(PDO::FETCH_ASSOC);
                            // Si la $user est faut alors on affiche un message comme quoi pas de user de ce type.
                            if(!isset($user['motDePasse']) || $user['motDePasse'] == ""){
                               echo "<p class=\"customer_checker\"> Oups ! Je ne trouve pas votre adresse mail. </p>";
                            }
                            else {
                                //Sinon, on compare le mot de passe hashé avec celui qui vient d'etre inserer voir s'il y a une correspondance
                                $validPassword = password_verify($_POST['password'], $user['motDePasse']);
                                // Si le mot de passe indiqué est bon alors on passe à la page d'accueil.
                                if($validPassword){
                                    // On ouvre une session...
                                    session_start();
                                    $_SESSION['customer_identity'] = $user['civilite_cli'].' '.$user['prenom_cli'].' '.$user['nom_cli'];
                                    $_SESSION['customer_id'] = $user['idClient'];
                                    $_SESSION['logged'] = true;
                                    header("Location: compte_bancaire.php");
                                }
                                else {
                                    echo "<p id=\"globalerror\"> Mot de passe invalide. </p>";
                                }
                            }
                        }
                    ?>
                    <section class="loginSection">
                        <div id="divClass">
                            <label for="Mot de passe">
                                <strong> Identifiant = email </strong>
                            </label>
                            <input type="text" name="identifiant" id="inputID"
                                placeholder="jacquard.bourse75@gmail.com">
                        </div>
                        <div id="divClass">
                            <label for="Confirmation">
                                <strong> Insérez votre mot de passe </strong>
                            </label>
                            <input type="password" name="password" id="inputID" placeholder="*********">
                        </div>
                    </section>
                    <input type="submit" name="seConnecter" value="Se connecter" id="submit">
                    <section class="NewPerso">
                        <p>
                            Mot de passe oublié ? Pas de panique ! <br> <a href="customerForgotPassword.php"
                                id="link-a"> Cliquez ici pour vous en créer un autre</a>.
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
    $('.customer_checker').fadeIn('slow', function() {
        $('.customer_checker').delay(7000).fadeOut();
    });
});

// Message de déconnection.
$(document).ready(function() {
    $('#globalerror').fadeIn('slow', function() {
        $('#globalerror').fadeOut(5500);
    });
});

// Erreur de mot de passe incompatible.
$(document).ready(function() {
    $('#password_error').fadeIn('slow', function() {
        $('#password_error').fadeOut(7000);
    });
});
</script>

</html>