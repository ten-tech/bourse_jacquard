<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="nouveauClient.css" media="screen" type="text/css" />
    <link rel="icon" type="image/png" sizes="36x36" href="icones/bank.png">
    <title>| Connexion |</title>
</head>

<body class="allBody">
    <form class="connexionForm">
        <section class="coSection">

            <h1> CONNEXION </h1>

            <div id="divSection">
                <label for=" identifiant"> Indentifiant </label>
                <input type="text" name="identifiant" required placeholder="jacquard@gmail.com">
            </div>

            <div id="divSection">
                <label for="mode de passe"> Mot de passe </label>
                <input type="password" name="motDePasse" required placeholder="Mot de p****">
            </div>

            <input type="submit" name="connexion" value="Connexion">

        </section>
        <footer>
            <p>Vous n'etes pas encore inscrit ? Suivez ce <a href="nouveauClient.php">lien</a> pour vous créer un
                compte.
            </p>
        </footer>
    </form>
</body>

</html>