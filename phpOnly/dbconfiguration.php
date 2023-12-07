<?php
/* =====>> Gestion de la connexion de la base de données avec PDO <<===== */
//session_start(); /* Ouverture de la session 
  $host     = 'localhost';
  $dbname   = 'bourses_data'; //
  $username = 'root'; // nom de la base
  $password = ''; // mot de passe
  try {

    /* Pour se connecter à la base de données avec l'objet pdo */
    $pdoConnection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    /* Un message de succès de connexion.
    echo "Connecté à $dbname sur $host avec succès."; */

  }
  catch (PDOException $execute) {
  /* Affichage de message d'erreur */
    die("Impossible de se connecter à la base de données $dbname :" . $execute->getMessage());
    trigger_error($e->getMessage(), E_USER_ERROR);
    (int)$e->getCode();

  }

  /* On protège la page contre les injections de code. */
  foreach ($_POST as $key => $value) {
	  $_POST[$key] = htmlspecialchars($value);
  }

?>