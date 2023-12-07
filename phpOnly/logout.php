<?php        
session_start();  
//session_destroy sert à detruire la session  
session_destroy();  
echo" A bientot";
// Je fais la redirection vers index4
Header('Location: customer_login.php');
?>