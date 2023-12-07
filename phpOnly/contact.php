<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../styles/nouveauClient.css" media="screen" type="text/css">
    <link rel="icon" type="image/png" sizes="36x36" href="../icones/bank.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <title> Accueil JacquardBourse </title>
</head>

<?php 
    //header("refresh: 15");
    ///echo date('H:i:s Y-m-d');
    // L'entete de la page
    require_once "header.php";
    // Verifer l'accès d'utilisateur par la variable $_session.
    require_once "session_verification.php";
?>

<body class="body">

    <form class="contact_advisor" method="POST">

        <section>
            <fieldset>
                <legend>
                    <h1>Je contacte mon/ma conseiller(e)</h1>
                </legend>
                <section>
                    <span id="contact_section">
                        <?php 
                            // Je recupere le conseiller de reférence
                            require_once("dbconfiguration.php");
                            foreach($pdoConnection->query("SELECT * FROM client natural join conseiller WHERE idClient = '".$_SESSION['customer_id']."' ") AS $data) {
                                if (!empty($data)) {
                                    // Si le conseiller est disponible, on affiche ces information, sinon on affiche une message disant q'il n'est pas présent.
                                    print "<aside class=\"customer_aside\"> Votre conseiller(e) est : <strong>". $data['civilite']." ". $data['prenom']." ".$data['nom']."</strong>. <br>
                                    Si vous essayez de lui envoyer un message via ce formulaire, votre message lui parviendra par<br> l'adresse mail suivante : <strong>".$data['email']."</strong>.</aside> <br>";   
                                }
                                else {
                                    echo "<aside> Votre conseiller(e) n'est plus disponible. </aside>";
                                }
                            }
                            /* *************************************************************************
                            * * * * * * * * * * * Pour afficher les conversations  * * * * * * * *  * *
                            ****************************************************************************
                            */
                            echo "<div class='for_conversation'>";
                            foreach($pdoConnection->query("SELECT * FROM contact_prive natural join conseiller WHERE idClient = '".$_SESSION['customer_id']."' ORDER BY id_cp DESC limit 15") as $conversation) {
                                if ($conversation) {
                                    // Si le conseiller est disponible, on affiche ces information, sinon on affiche une message disant q'il n'est pas présent.
                                    print "<div id='discussion'><aside class='vous'> Vous : <strong>". $conversation['objet']."</strong> <br><br/>" ." ". $conversation['message']." "."</aside> <p class='date'> ".$conversation['date_envoi']."</p> <br>";
                                }
                                else {
                                    echo "<aside> VOus n'avez aucune conversation à ce jour. </aside>";
                                }
                            }
                            echo " </div>";
                            
                            /* *************************************************************************
                            * * * * * * TRAITEMENT DU FORMULAIRE D'ENVOI DE MESSAGE * * * * * * * *  * *
                            ****************************************************************************
                            */
                            echo "<div>";
                            if(isset($_POST['submit'])) {
                                $objet   = htmlentities($_POST['object']);
                                $message = htmlspecialchars($_POST['message']);
                                # Je verifie si les deux variables ne sont pas vides avant d'executer la suite
                                if(empty($objet) && empty($message)) {
                                   // On reste sur la meme page ne affichant un message de champ vide
                                   echo "<p id='error'> Je ne peux envoyer de message vide :( </p>";
                                  
                                }
                                # Si l'objet n'est pas vide mais le champ de message est vide, alors on affiche un message
                                # de type pas de corps de message.
                                elseif (!empty($objet) && empty($message)) {
                                    echo "<p> Il m'est impossible d'envoyer l'objet sans le corps de votre message :( ! </p>";
                                    die();
                                }
                                else {
                                    //var_dump($_POST);
                                    $send_message = $pdoConnection->prepare("INSERT INTO contact_prive VALUES(NULL, :objet, :message, now() ,'".$_SESSION['customer_id']."', '".$data['idCnll']."')");
                                    $send_message->bindValue(':objet', $objet, PDO::PARAM_STR);
                                    $send_message->bindValue(':message', $message, PDO::PARAM_STR);
                                    $send_message->execute();
                                    $send_message->fetch(PDO::FETCH_ASSOC);
                                    

                                    if ($send_message) {
                                        // Succès
                                       // echo "<p id ='succes'> Message envoyé avec succès :) !</p>";
                                    }
                                    else {
                                        // Erreur d'envoi
                                        echo " <p id='error'> Oups !! Il m'st impossible d'envoyer votre message pour le moment.
                                         Veillez réessayer ulterieurement.";
                                    }
                                }
                            }
                            echo "</div>";

                        ?>
                    </span>
                </section>
            </fieldset>
        </section>
        <span class="messenger">
            <div class="object">
                <label for="email"> <strong> Objet : </strong> </label>
                <input type="text" name="object" placeholder="Objet" id="type_object">
            </div>

            <div>
                <textarea id="message" name="message" rows="5" placeholder="Insérez votre message ici ..."
                    cols="80"></textarea>
            </div>
        </span>
        <input type="submit" name="submit" value="Envoyer" class="submit">
    </form>
    <!-- Pour afficher de conseiller existe  -->
    <script type="text/javascript">
    $(document).ready(function() {
        $('#error').fadeIn('slow', function() {
            $('#error').delay(7000).fadeOut();
        });
    });

    // Pour afficher un message d'echec
    $(document).ready(function() {
        $('.error').fadeIn('slow', function() {
            $('.error').delay(5000).fadeOut();
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