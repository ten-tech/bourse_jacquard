<?php 
include "dbconfiguration.php";

/* *************************************************************************************************************
*++++++++++++++++++++++++++++++++++++++++++ GESTION DE PRIX DES INDICES +++++++++++++++++++++++++++++++++++++++*
* ************************************************************************************************************ */
foreach($pdoConnection->query("SELECT *, format(dernier, 2) AS prix_unitaire FROM bourse_data  WHERE idBourseName = 1 ORDER BY idBourseData desc limit 20") as $pricer){

    if(isset($pricer['prix_unitaire'])){

        $prix_unitaire = $pricer['prix_unitaire'];

        echo $prix_unitaire;

        $new_price = $pdoConnection->query("UPDATE bourse_data SET prix = {$prix_unitaire} WHERE idBourseName = 1 ORDER BY idBourseData");
        // On vérifie si l'insertion à été fait.
        if (isset($new_price)) {
            echo " <strong>Nouveau prix mise à jour ! </strong> <br>";
        }
        else {
            echo "Erreur de mise à jour des prix";
        }
        
    }
     else{
        echo "Jamais pret";
    }


}
 
?>
//Getting value from "ajax.php".

function fill(Value) {

//Assigning value to "search" div in "search.php" file.

$('#search').val(Value);

//Hiding "display" div in "search.php" file.

$('#display').hide();

}

<script>
$(document).ready(function() {

    //On pressing a key on "Search box" in "search.php" file. This function will be called.

    $("#search").keyup(function() {

        //Assigning search box value to javascript variable named as "name".

        var name = $('#search').val();

        //Validating, if "name" is empty.

        if (name == "") {

            //Assigning empty value to "display" div in "search.php" file.

            $("#display").html("");

        }

        //If name is not empty.
        else {

            //AJAX is called.

            $.ajax({

                //AJAX type is "Post".

                type: "POST",

                //Data will be sent to "ajax.php".

                url: "ajax.php",

                //Data, that will be sent to "ajax.php".

                data: {

                    //Assigning value of "name" into "search" variable.

                    search: name

                },

                //If result found, this funtion will be called.

                success: function(html) {

                    //Assigning result to "display" div in "search.php" file.

                    $("#display").html(html).show();

                }

            });

        }

    });

});
</script>