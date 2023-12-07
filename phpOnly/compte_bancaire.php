<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../styles/nouveauClient.css" media="screen" type="text/css">
    <link rel="icon" type="image/png" sizes="36x36" href="../icones/bank.png">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="contact.js"></script>
    <title> Accueil JacquardBourse </title>
</head>

<?php 
    require_once "dbconfiguration.php"; # Configuration de la base de données
    require_once "header.php"; // L'entete de la page
    require_once "session_verification.php"; // Verifer l'accès d'utilisateur par la variable $_session.
?>

<body class="body">

    <div class="compte_info">
        <section>
            <fieldset>
                <legend>
                    <h1>Mon compte</h1>
                </legend>

                <section class="compte_client">
                    <?php
                        echo "<P> Bonjour <strong>".$_SESSION['customer_identity']."</strong> !</P> <br/>";
                        echo "<span>"; 
                        //var_dump($_SESSION['customer_identity']);
                        if($_SESSION['customer_identity']){
                            // Par natural join, je vais selectionner toutes les données du client pour pouvoir les afficher là où il faut. 
                            foreach  ($pdoConnection->query(" SELECT * FROM portefeuille NATURAL JOIN client WHERE  idClient = '".$_SESSION['customer_id']."' ") AS $row) {
                                
                                // J'affiche le numéro unique du compte du client.
                                print "<div id=\"customer_information\"><label for=\" N° du compte\"> N° unique du compte : </label> <strong>".$row['numero_unique']."</strong></div> <br>";
                                print "<div id=\"customer_information\"><label for=\" Solde\">Solde : </label><strong>".$row['solde']."</strong> €</div><br>";
                                /*
                                Cette troisième ligne permet d'afficher la dernière activité que notre client/e aurra fait ou pas.
                                Pour celà, je vais chercher la liste cette information dans la table action de la base de données en faisant
                                une jointure e type "INNER JOIN" pour selectionner en amont l'identifiant du client qui se trouve dans la table client.
                                Je ferai ensuite verifier cette information dans une condition if de telle sorte que si la colone est vide, on affiche un message
                                de type "Vous n'avez aucune activité effectuée à présent."
                                
                                */
                                // print "<div><strong>".$row['']."</strong></div><br>";
                        
                                print "<div id=\"customer_information\"><label for=\"Date d'ouverture\"> Date d'ouverture : </label><strong>".$row['dateOuverture']."</strong></div>";
                                
                            }
                            
                        // $get_numero_unique = $pdoConnection->query(" SELECT numero_unique FROM portefeuille NATURAL JOIN client WHERE  idClient = '".$_SESSION['customer_id']."' ");
                        }
                        echo"</span>";
                            
                    ?>
                </section>

            </fieldset>
        </section>
    </div>

</body>

</html>