<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../styles/nouveauClient.css" media="screen" type="text/css" />
    <link rel="icon" type="image/png" sizes="36x36" href="../icones/bank.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title> Client || Créer un mot de passe </title>
</head>

<body class="body">
    <?php
        include_once("dbconfiguration.php");
        if (isset($_POST['email'], $_POST['motDePasse'], $_POST['confirmation'])){

            // Variable de recuperation des post
            $email   = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['motDePasse']);
            $password_conf = htmlspecialchars($_POST['confirmation']);

            // On verifie par cette fonction si la procedure de vérification d'éventuelle existance d'utilisateur a abouti ou pas.
            # Verification du mot de passe et sa confirmation 
            if ($email != NULL) {

                // Verifier l'adresse mail du client
                $check_customer_email = $pdoConnection->prepare('SELECT count(*) AS email_checked FROM client WHERE email_cli = :email');
                $check_customer_email->execute([':email' => $email]);
                $customer_email_exists = $check_customer_email->fetchObject();

                if ($customer_email_exists->email_checked > 0) {
                
                    /* On paramétre Le "cost" à 12.*/
                    $optionsCost = ['cost' => 12];
                    /* Hachage du mot de passe */
                    $mdpHash = password_hash($password_conf, PASSWORD_BCRYPT, $optionsCost);
                    /* Variable sql d'insertion */

                    if ($pdoConnection->query("UPDATE client SET motDePasse = '$mdpHash' WHERE email_cli = '$email'") && $password == $password_conf) {
                        header("Location: customer_login.php"); 
                    }
                    else {
                        echo "<p class=\"erreur1\"> Oups !! Mot de passe incompatible à sa confirmation. </p> ";
                    }
                }
                else {
                    echo "<p id='globalerror'> Oups !! Adresse mail introuvable.</p>";
                }
            }
            else {
                echo "<p class=\"erreur1\"> Il est nécessaire de vérifer votre adresse mail. </p>";
            }
            
            
        }
    ?>
    <form class="passwordForm" action="customerPassword.php" method="POST">
        <div>

            <h1> Créer un mot de passe </h1>
            <section class="passwordClass">
                <div class="divClass">
                    <label for=" Mot de passe"> Vérifier votre adresse mail </label>
                    <input type="email" name="email" id="inputID" placeholder="bienvenue@gmail.com">
                </div>
                <div class="divClass">
                    <label for=" Mot de passe"> Inserer votre mot de passe </label>
                    <input type="password" name="motDePasse" id="inputID" placeholder="*********">
                </div>
                <div class="divClass">
                    <label for="Confirmation"> Confirmer votre mot de passe</label>
                    <input type="password" name="confirmation" id="inputID" placeholder="*********">
                </div>
            </section>
        </div>
        <input type="submit" name="submit" value="VALIDER" class="submit">
    </form>
    <!-- Pour afficher de conseiller existe  -->
    <script type="text/javascript">
    $(document).ready(function() {
        $('.customer_exists').fadeIn('slow', function() {
            $('.customer_exists').delay(7000).fadeOut();
        });
    });

    // Pour afficher un message d'echec
    $(document).ready(function() {
        $('.erreur1').fadeIn('slow', function() {
            $('.erreur1').delay(5000).fadeOut();
        });
    });

    // Inscription reussite 
    $(document).ready(function() {
        $('.execution').fadeIn('slow', function() {
            $('.execution').delay(5000).fadeOut();
        })
    });

    // Erreur de champs vide ou de frappe
    $(document).ready(function() {
        $('#globalerror').fadeIn('slow', function() {
            $('#globalerror').fadeOut(6500);
        });
    });
    </script>
</body>

</html>