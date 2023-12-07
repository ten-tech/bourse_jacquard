<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../styles/nouveauClient.css" media="screen" type="text/css" />
    <link rel="icon" type="image/png" sizes="36x36" href="../icones/bank.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title> Inscription || Nouveau Client </title>
</head>

<body class="body">
    <section class="allForYou">

        <form id="formForForm" method="post" action="" autocomplete="off">
            <?php
                /* =====>> On inclure la configuration de la base de données <<===== */
                include_once("dbconfiguration.php");
                if (isset($_POST['genre'], $_POST['nom'], $_POST['prenom'], $_POST['anniversaire'], $_POST['email'], $_POST['telephone'], $_POST['SelectConseiller'])) {
                    /* Variable de récupération de données */
                    $civilite   = htmlspecialchars($_POST['genre']);
                    $nom	    = htmlspecialchars($_POST['nom']);
                    $prenom     = htmlspecialchars($_POST['prenom']);
                    $anniv	    = htmlspecialchars($_POST['anniversaire']);
                    $email      = htmlspecialchars($_POST['email']);
                    $numTel     = htmlspecialchars($_POST['telephone']);
                    $conseiller = htmlspecialchars($_POST['SelectConseiller']);

                    // Procédure de verification d'une éventuelle existance d'utilisateur par mail.
                    $check_customer = $pdoConnection->prepare("SELECT * FROM client WHERE email_cli = :email");
                    $check_customer->bindValue('email', $email, PDO::PARAM_STR);
                    $check_customer->execute();
                    
                    $customer_exists = $check_customer->fetch(PDO::FETCH_ASSOC);
                    // On verifie par cette fonction si la procedure de vérification d'éventuelle existance d'utilisateur a abouti ou pas.
                    if ($customer_exists != NULL) {
                        echo "<p class=\"customer_exists\"> J'ai déjà une personne nommée : <strong>$prenom "." $nom</strong> dans ma base de données. <br>
                        Je ne peux donc l'inscrire pour une  deuxième.<br> En revanche, <strong> $civilite "." $nom</strong>  peut se connecter avec son identifiant <i>$email </i>.</p>";
                    }
                    /* On vérifie si les variables ne sont pas vides et si les mots de passe inssérés sont identiques. */
                    else{
                        if($civilite != NULL && $nom != NULL && $prenom != NULL && $anniv != NULL && $email != NULL && $numTel != NULL && $conseiller != NULL) {
                            // On selectionne dans la table conseiller le nom du conseiller faisant l'action
                            $resultat = $pdoConnection->prepare(" INSERT INTO client VALUES(NULL, :civilite, upper(:nom), :prenom, :anniv, :email, NULL, :numTel, now(), NULL, :conseiller) ");
                            // On associe les valeurs
                            $resultat->bindValue(':civilite', $civilite, PDO::PARAM_STR);
                            $resultat->bindValue(':nom', $nom, PDO::PARAM_STR);
                            $resultat->bindValue(':prenom', $prenom, PDO::PARAM_STR);
                            $resultat->bindValue(':anniv', $anniv, PDO::PARAM_STR);
                            $resultat->bindValue(':email', $email, PDO::PARAM_STR);
                            $resultat->bindValue(':numTel', $numTel, PDO::PARAM_INT);
                            $resultat->bindValue(':conseiller', $conseiller, PDO::PARAM_STR);
                            // On execute les valeurs dans un tableau
                            // Si l'insertion a été faite, on affiche un message de succès sinon on affiche un message d'erreur par la fonction suivante.
                            if($resultat->execute()){
                                echo "<p class=\"execution\"> Bien joué(e)! L'inscription de $civilite "." $nom "." $prenom est prise en compte. <br> </p>";
                                
                                // On execute ce fichier python qui envoie un mail au client pour se créer n mot de passe.
                                $code_retour = exec('python3 customer_mailer.py');
                                if (!$code_retour) {
                                    
                                    echo "<p class=\"execution\"> Un mail vient d'etre envoyé à $civilite "." $nom "." $prenom  pour la création de son mot de passe </p>";

                                }
                                else {
                                    echo "<p class=\"execution\"> L'inscription de $civilite "." $nom "." $prenom est prise en compte, <br> 
                                    mais je ne peux lui envoyer le mail de création de son mot de passe. </p>";
                                }

                                /* *****************************************************************************************************
                                * ********** DEUXIEME GRANDE PARTIE DU PROGRAMME QUI PERMET D'ACTIVER LE COMPTE DES CLIENTS ***********
                                * ************************************************************************************************** */
                                // Je concatene le nom, le numero et le prenom pour faire une numero unique.
                                $_numero_du_compte = $numTel.$nom.$prenom;
                                // On fixe la limite de la chaine de caractere à 16
                                $limite = 16;
                                //Je genère le numero unique du client dans la chaine de caractere.
                                $numero_unique = substr(str_shuffle($_numero_du_compte), 0, $limite);
                                // Je commence à faire l'insertion des données du client.
                                if(isset($numero_unique)) {
                                    // Je vais d'abord selectionner le client qui vient d'etre d'inscrit pour pouvoir faire la liaison de données
                                    foreach($pdoConnection->query("SELECT * FROM client WHERE email_cli = '".$email."'  and telephone = '".$numTel."' and nom_cli = '".$nom."'") AS $row) {
                                        $customer_id = $row['idClient'];
                                        // Je mets le solde du client à 100
                                        $solde = 100.00;
                                        // J'initialise la valeur du portefeuille à 0 
                                        $valeur_portefeuille = 0.00;
                                        
                                        $insert_num = $pdoConnection->prepare('INSERT INTO portefeuille values(NULL, :numero_unique, :solde, :valeur_portefeuille, :customer_id)');
                                        $insert_num->bindValue(':solde', $solde , PDO::PARAM_INT);
                                        $insert_num->bindValue(':valeur_portefeuille', $valeur_portefeuille, PDO::PARAM_INT);
                                        $insert_num->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
                                        $insert_num->bindValue(':numero_unique', $numero_unique, PDO::PARAM_STR);
                                        $executed = $insert_num->execute();

                                        if($executed != NULL) {
                                        echo "<p class=\"execution\"> Son portefeuille est aussi activé.</p>";
                                        }
                                        else{
                                        echo "<p class=\"erreur1\"> Echec d'activation du compte. </p>";
                                        }
                                    }
                                    
                                }else {
                                echo "<p class=\"erreur1\"> Erreur d'initialisation du portefeuille client ... </p>";
                                }
                                
                            }
                            else{
                                echo "<p class=\"erreur1\"> Oups !! Ce n'est pas vous c'est moi. Il m'est impossible de faire une inscription pour le moment.</p>";
                            }

                        }
                        else {
                            echo "<p id=\"globalerror\"> Oups !! Il est necessaire de remplire tous les champs.</p>";
                        }
                    }
                }

            ?>
            <h1 id="allH1"> Inscription || Client(e)</h1>

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
                        <input type="text" name="nom" id="inputID">
                    </div>

                    <div>
                        <label for="prenom"> <strong> Prénom </strong> </label>
                        <input type="text" name="prenom" id="inputID">
                    </div>

                    <div>
                        <label for="anniversaire"> <strong> Date de naissance </strong> </label>
                        <input type="date" name="anniversaire" id="inputID">
                    </div>

                </fieldset>
            </section>

            <section>
                <fieldset id="informationSection">
                    <legend> Coordonnées </legend>

                    <div>
                        <label for="email"> <strong> Adresse électronique </strong> </label>
                        <input type="email" name="email" placeholder="jacquard@gmail.com" id="inputID">
                    </div>

                    <div>
                        <label for="phone"> <strong>Téléphone</strong> </label>
                        <input type="tel" name="telephone" min="0" max="10" placeholder="0123456789" id="inputID">
                    </div>
                </fieldset>
            </section>

            <section>
                <fieldset id="conseiller">
                    <legend> Confirmez l'inscription en selectionnant votre identité</legend>
                    <select name="SelectConseiller" class="select-control">
                        <option value="" disabled selected> Identifiez-vous </option>
                        <?php
                            // Pour lister les conseiller(e)s disponibles 
                            //require_once("dbconfiguration.php");
                            $option = $pdoConnection->query('SELECT idCnll, civilite, nom, prenom FROM conseiller ORDER BY idCnll ASC');
                            while ($row = $option->fetch()) {
                                echo "<option value='".$row['idCnll']."'>" .$row['idCnll'] . " " .$row['civilite'] . " " .$row['nom']." " .$row['prenom'] . "</option>";
                            } 
                        ?>
                    </select>
                </fieldset>
            </section>
            <input type="submit" name="submit" class="submit" value="Inscrire">
        </form>

    </section>
</body>
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
        $('.execution').delay(10000).fadeOut();
    })
});

// Erreur de champs vide ou de frappe
$(document).ready(function() {
    $('#globalerror').fadeIn('slow', function() {
        $('#globalerror').fadeOut(6500);
    });
});
</script>

</html>