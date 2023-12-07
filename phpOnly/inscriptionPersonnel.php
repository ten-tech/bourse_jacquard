<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../styles/inscriptionPersonnel.css" media="screen" type="text/css" />
    <link rel="icon" type="image/png" sizes="36x36" href="../icones/bank.png">
    <title> Inscription du personnel </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body class="body">

    <form id="formForForm" method="post" action="" autocomplete="off">
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

        <h1 id="allH1"> Inscription du personnel </h1>
        <section class="containerForCivilite">
            <fieldset>
                <legend class="sr-only"> Êtes-vous un homme ou une femme ? </legend>
                <div id="icone-radio-civilite">
                    <input type="radio" id="monsieur" name="genre" value="Monsieur">
                    <label for="monsieur">
                        <span class="sr-only"> Monsieur </span>
                        <img src="../icones/male.png" width="86" hight="86" alt="Monsieur">
                    </label>
                </div>

                <div id="icone-radio-civilite">
                    <input type="radio" id="madame" name="genre" value="Madame">
                    <label for="madame">
                        <span class="sr-only"> Madame </span>
                        <img src="../icones/female.png" width="86" hight="86" alt="Madame">
                    </label>
                </div>
            </fieldset>
        </section>

        <section>
            <fieldset id="nameSection">
                <legend> Informations personnelles </legend>

                <div>
                    <label for="nom"> <strong> NOM </strong> </label>
                    <input type="text" name="nom" id="inputID" autocomplete="off" placeholder="PROJET">
                </div>

                <div>
                    <label for="prenom"> <strong> Prénom </strong> </label>
                    <input type="text" name="prenom" id="inputID" autocomplete="off" placeholder="Bourse">
                </div>
                <div>
                    <label for="email"> <strong> Email </strong> </label>
                    <input type="email" name="email" id="inputID" autocomplete="off"
                        placeholder="btssnir.bourse@gmail.com">
                </div>
                <div>
                    <label for="password"> <strong> Mot de passe</strong> </label>
                    <input type="password" name="motDePasse" id="inputID" placeholder="*******">
                </div>
                <div>
                    <label for="passwordConfirm"> <strong>Confirmez votre mot de passe</strong> </label>
                    <input type="password" name="motDePasseConfirm" id="inputID" autocomplete="off"
                        placeholder="*******">
                </div>

            </fieldset>
        </section>
        <input type="submit" name="submit" value="CREER" id="submit">
        <p> Avez-vous déjà un compte ? <a href="loginPerson.php" class="login">Cliquez ici pour vous connecter</a>.</p>
    </form>
    <!-- Pour afficher de conseiller existe  -->
    <script type="text/javascript">
    $(document).ready(function() {
        $('#user_exists').fadeIn('slow', function() {
            $('#user_exists').delay(7000).fadeOut();
        });
    });

    // Pour afficher un message d'echec
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
</body>

</html>