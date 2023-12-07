<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../styles/nouveauClient.css" media="screen" type="text/css">
    <link rel="icon" type="image/png" sizes="36x36" href="../icones/bank.png">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <title> Vente d'indice </title>
</head>

<?php
    require_once "dbconfiguration.php"; # COnfiguration de bdd
    require_once "header.php"; # L'entete de la page
    require_once "session_verification.php"; # Verifer l'accès d'utilisateur par la variable $_session.
?>

<body class="body">
    <fieldset>
        <legend>
            <h1> Je fais une ou des vente(s) d'indice </h1>
        </legend>
        <form method="post" id="selling_data">
            <section>
                <?php
                    echo "<span>";
                    // Par jointure interne, je vais selectionner tout ce que le client à acheter pour pouvoir les les mettre 
                    //sur le marche de la bourse.
                    $for_sale = $pdoConnection->query(" SELECT * FROM achat INNER JOIN client on achat.idAchat = client.idClient
                     WHERE idCLient LIKE '".$_SESSION['customer_id']."' ORDER BY date_achat DESC");
                    // On verifie si la table achat n'est pas vide.
                    if(empty($for_sale)) {
                        echo "<p> Hey ".$_SESSION['customer_identity']." vous avez le choix de vendre vos indices. Genial n'est-ce pas ? <br/>
                        N'hésitez pas vous démarquer sur le marche de la bourse. <p>";
                    }
                    else {
                        echo "<p> Il n'est pas encore tant de proposer quelque chose sur le marché de la bourse ".$_SESSION['customer_identity'].".<br/>
                         Celà sera possible dès que vous ferez vos premier pas sur ce marché.
                        N'hésitez pas à vous démarquer sur le marche de la bourse. <p>";
                    }
                    echo"</span>";
                    ?>
            </section>
        </form>
    </fieldset>
</body>

</html>