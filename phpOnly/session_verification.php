<?php 
//header("Refresh:1");
session_start();

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
***** CE FICHIER CONSISTE A PROTEGER LES PAGES QUI EXIGENT UNE CONNECTION AVANT D'Y ACCEDER. ********
************ DANS CE CAS, JE FERAI APPEL A CETTE PAGE DANS LES FICHIERS QUI SENSIBLES. **************
  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
if(!isset($_SESSION['logged']) || !$_SESSION['logged']){
    /* Si la connection n'est pas vraie ou tout simplement si la connection est vide, 
    alors on fait la redirection vers la page de connexion. */
    header('Location: customer_login.php');
}

?>