<!DOCTYPE html>
<html lang="fr">
<?php
    // La configuration de l base de données.  
    require_once "dbconfiguration.php";
    // L'entete de la page
    require_once "header.php";
    // Verifer l'accès d'utilisateur par la variable $_session.
    require_once "session_verification.php";
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../styles/nouveauClient.css" media="screen" type="text/css">
    <link rel="icon" type="image/png" sizes="36x36" href="../icones/bank.png">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <title> Ma synthèse </title>
</head>

<body class="body">

    <div class="compte_info">
        <section>
            <fieldset>
                <legend>
                    <h1>Mes activités </h1>
                </legend>

                <section class="compte_client">
                    <?php
                        echo "<span>";
                        // Pour afficher les action du client. 
                        $synthese_du_compte = $pdoConnection->query("SELECT * FROM action INNER JOIN portefeuille
                         ON action.idAction = idPortefeuille WHERE client.idClient = '".$_SESSION['customer_id']."'");
                        if (empty($synthese_du_compte)) {
                            echo "<P><strong>".$_SESSION['customer_identity']."</strong>, vous n'avez effectué aucune action à ce jour.<br/>
                             Suivez ce <a href=\"buying.php\">lien ci-dessous </a> pour faire un tour sur le marcher de la bourse. </P>";
                        }
                        else {
                            print"<p> Le ".$synthese_du_compte['datebd']." vous avez acheté le ".$synthese_du_compte['coursName']."
                             dont sa valeur forte était de ".$synthese_du_compte['valeur_h']." et son volume de ".$synthese_du_compte['volume']."</p>";
                        } 

                        echo"</span>";

                    ?>
                </section>
            </fieldset>
            <form method="post" action="synthese.php" id="actions">

            </form>
        </section>
    </div>

</body>

</html>