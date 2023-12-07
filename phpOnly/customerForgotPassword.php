<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../styles/nouveauClient.css" media="screen" type="text/css" />
    <link rel="icon" type="image/png" sizes="36x36" href="../icones/bank.png">
    <title> Client || Mot de passe oublié </title>
</head>

<body class="body">
    <form class="passwordForm" action="customerForgotPassword.php" method="POST">

        <h1> Créer un nouveau mot de passe </h1>
        <?php
            include_once("dbconfiguration.php");
            if (isset($_POST['email'], $_POST['motDePasse'], $_POST['confirmation'])){
                print_r($_POST);
                // Variable de recuperation des post
                $email   = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['motDePasse']);
                $password_conf = htmlspecialchars($_POST['confirmation']);

                // On verifie par cette fonction si la procedure de vérification d'éventuelle existance d'utilisateur a abouti ou pas.
                # Verification du mot de passe et sa confirmation 
                if ($email != NULL) {

                    // Verifier l'adresse mail du client
                    $check_customer_email = $pdoConnection->query("SELECT * FROM client WHERE email_cli = '".$email."'");
                    $customer_email_exists = $check_customer_email->fetch(PDO::FETCH_ASSOC);
                    if ($customer_email_exists > 0) {
                    
                        if($password == $password_conf) {
                            $check_customer_password  = $pdoConnection->query("SELECT motDePasse FROM client WHERE motDePasse = '".$password_conf."'");
                            $customer_password_exists = $check_customer_password->fetch(PDO::FETCH_ASSOC);
                            /* Si on n'as pas le meme mot de passe ou si le champ mot de passe du client est vide,
                                alors on le laisse créer un nouveau mot de passe.
                            */
                            if (!isset($customer_password_exists['motDePasse']) || $customer_password_exists['motDePasse'] == NULL) {

                                /* On paramétre Le "cost" à 12.*/
                                $optionsCost = ['cost' => 12];
                                /* Hachage du mot de passe */
                                $mdpHash = password_hash($password_conf, PASSWORD_BCRYPT, $optionsCost);
                                // Je verifie le mot de passe qui vient d'etre indiqué s'il n'est pas égal à celui qui est dans la table du client.
                                
                                $pdoConnection->query("UPDATE client SET motDePasse = '".$mdpHash."' WHERE email_cli = '".$email."'");
                                
                                header("Location: customer_login.php");

                            }
                            else {
                                echo "<p> Oups, il me semble que le mot que vous venez d'indiquer est pareil que le précédent oublié. <br>
                                Utilisez le pour vous connecter ou créez-en un autre.</p>";
                            }
                        }
                        else {
                            echo "<p class=\"erreur1\"> Oups !! Mot de passe incompatible à sa confirmation. </p> ";
                        }
                    }
                    else {
                        echo "<p id='globalerror'> Oups !! Je ne connais pas cette adresse mail.</p>";
                    }
                }
                else {
                    echo "<p class=\"erreur1\"> Il est nécessaire de vérifer votre adresse mail. </p>";
                }
            }
        ?>
        <section class="passwordClass">
            <div class="divClass">
                <label for="Email"> Indiquez votre adresse mail</label>
                <input type="email" name="email" id="inputID" placeholder="jacquard.bourse@gmail.com">
            </div>
            <div class="divClass">
                <label for="Mot de passe">Nouveau mot de passe </label>
                <input type="password" name="motDePasse" id="inputID" placeholder="*********">
            </div>
            <div class="divClass">
                <label for="Confirmation"> Confirmer le mot de passe </label>
                <input type="password" name="confirmation" id="inputID" placeholder="*********">
            </div>
        </section>
        <input type="submit" name="submit" value="Confirmer" class="submit">
    </form>
</body>

</html>