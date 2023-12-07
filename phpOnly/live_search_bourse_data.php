<?php
    // J'inclus le fichier de configuration de la base de données.
    require_once "dbconfiguration.php";
        // Obtenir la valeur de la variable "live_searchPA" à partir de "script.js".
        if (isset($_POST['live_search_data'])) {
            // Déclaration des variables qui vont correspondre aux saisies du client depuis la barre de recherche
            $bourse_data_info = $_POST['live_search_data'];
            // Chercher $selectPA.
            var_dump($_POST['live_search_data']);
            $data_query = "SELECT * FROM `bourse_data` WHERE `idBourseName` = 1 and coursName LIKE :bourse_data_info LIMIT 10";
            $select_data = $pdoConnection->prepare($data_query);
            $select_data->execute(array('bourse_data_info' => '%' .$bourse_data_info. '%'));
            // Création d’une liste non ordonnée pour afficher le résultat.
            $all_data = $select_data->fetchAll();
                if (isset($all_data) && !empty($all_data)) {
                        print_r($all_data);
                        echo $all_data;


                }
                else{
                    echo "<p>Il y a un problème de recuperation de données.</p>";
                }
        }
        die();

 /*
  if (isset($_POST['query'])) {
      $query = "SELECT * FROM Songs WHERE song_name LIKE '{$_POST['query']}%' LIMIT 100";
      $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($res = mysqli_fetch_array($result)) {
        echo $res['song_name']. "<br/>";
      }
    } else {
      echo "
      <div class='alert alert-danger mt-3 text-center' role='alert'>
          Song not found
      </div>
      ";
    }
  }
  */

?>