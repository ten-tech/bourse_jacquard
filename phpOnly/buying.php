<!DOCTYPE html>
<html lang="fr">
<?php
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
    <title> Achat d'indice </title>
</head>

<body class="body">
    <fieldset>
        <legend>
            <h1> Je fais un ou des achat(s) d'indice </h1>
        </legend>

        <form method="post" id="buying_data">
            <!-- Pour la barre de recherche -->
            <section class="searchBox">
                <input class="searchInput" type="text" name="live_search_data" id="live_search_data"
                    placeholder="Faites une rechercher par Nom d'indice, Volume, Dernier">
                <button class="searchButton">
                    <i class="material-icons">
                        <img src="../icones/search2.png" alt="Recherche" id="search_image">
                    </i>
                </button>
                <div id="data_result"></div>
                <div id="back_space" style="display: none"></div>
                <script type="text/javascript">
                $(document).ready(function() {
                    // En appuyant sur une touche "live_search_data" ou la barre de recherche. Cette fonction sera appelée.
                    $("#live_search_data").keyup(function() {
                        //Assigner la valeurs de la zone de recherche à la variable javascript nommée "indice_info" et autres
                        $('#data_result').hide();
                        $('#back_space').css("data_result", "none");
                        var indice_info = $('#live_search_data').val();

                        //Validation, si les variables ne sont vides
                        if (indice_info == "") {
                            //Assigning empty value to "display" div in "index.php" file.
                            $('#back_space').css("data_result", "block");
                        }
                        // Si indice_info n'est pas vide.
                        else {
                            //AJAX est appelé.
                            $.ajax({
                                // L'on peut voir que j'utilise la méthode "POST".
                                method: "POST",
                                //Data sera envoyé à "liveSearchAsso.php".
                                url: "live_search_bourse_data.php",
                                //Data, c'est ce qui sera envoyé à "liveSearchAsso.php".
                                data: {
                                    //Assignement de la valeur contenant dans la variable "indice_info" dans "live_searchPA"
                                    live_search_data: indice_info
                                },
                                // Cette fonction permet d'afficher les resultats en cas de succès
                                success: function(html) {
                                    if (html == '') {
                                        $().css("data_result", "block");
                                    } else {
                                        // Les resultats du fichier "liveSearchAsso.php" sont assignées dans cette div.
                                        $("#data_result").html(html).show();
                                    }
                                }
                            });
                        }
                    });
                });
                </script>
            </section>

            <section>
                <?php
                    require_once "dbconfiguration.php";

                    // Par natural join, je vais selectionner toutes les données du client pour pouvoir les afficher là où il faut.
                    foreach  ($pdoConnection->query(" SELECT *, format(dernier,2) AS prix_unitaire FROM bourse_data
                     WHERE idBourseName = 1 ORDER BY idBourseData DESC LIMIT 40") AS $data) {
                        if(!empty($data)) {
                            // On affiche par bouton les indices disponibles.
                            print "<button class=\"data_button\" onclick=\"button\"> <h1>".$data['coursName']."</h1><br/>
                                <p> Valeur d'ouverture :".$data['ouverture'].''."<br/>
                                    Valeur maximal : ".$data['valeur_h']."<br/>
                                    Valeur minimale : ".$data['valeur_b']."<br/>
                                    Volume : ".$data['volume']."<br/>
                                    Date d'ouverture: ".$data['datebd']."</p</button><br> <br/>";
                            print "<aside> Prix : ".$data['prix_unitaire']."  €</aside>";

                        }        
                        else {
                            echo "<p> Il n'y a pas d'indice disponible pour le moment :( </p>";
                        }

                    }

                ?>
            </section>
        </form>
    </fieldset>
</body>

</html>