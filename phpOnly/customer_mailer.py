# Importation des modules
import smtplib
from email.message import EmailMessage
from email.utils import formatdate
import mysql.connector as pdoConnection

# *********************** Connexion à la base de données pour envoyer un mail au client *********************
try:
    connection = pdoConnection.connect(
        host='localhost',
        database='bourses_data',
        user='Bourse',
        password='December!1234'
    )
    # objet cursor qui nous permet d'executer une action vers la base de données.
    cursor = connection.cursor()
    # On recupere la dernière ligne de la table client pour envoyer le mail.
    cursor.execute(
        "SELECT email_cli FROM client ORDER BY idClient DESC LIMIT 1")
    email_client = cursor.fetchone()

    # On verifie si la recuperation a été faite
    if(email_client != 0):
        message = "Adresse mail trouvé est : "
        all_message = message + " ".join(email_client)
        print(all_message)
        with smtplib.SMTP_SSL('smtp.gmail.com', 465) as smtp:

            user_login = smtp.login(
                'btsts2projetbourse@gmail.com', 'December!1234')
            msg = EmailMessage()
            msg['Subject'] = " Bienvenue chez JacquardBourse ! "
            msg['From'] = user_login
            msg['To'] = email_client
            msg["Date"] = formatdate(localtime=True)

            # Première possibilité d'envoi sans html
            text_content = """
            JacquardBourse

            Bienvenue chez JacquardBourse !

            Afin de finaliser votre inscription, je vous prie de suivre <a href="customerPassword.php">le lien suivant pour
            vous créer un mot de passe unique</a>. <br>
            """

            # Deuxième possibilité d'envoi avec html
            html_content = """
                <html>
                    <head>
                        <meta charset="utf-8" />
                        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                        <link rel="stylesheet" href="../styles/nouveauClient.css" media="screen" type="text/css"/>
                        <title> Création de mot de passe </title>
                    </head>
                    <body>
                        <div>
                            Bienvenue chez JacquardBourse !<br>

                            Afin de finaliser votre inscription, je vous prie de suivre <a href="customerPassword.php">le lien suivant pour
                            vous créer un mot de passe unique</a>. <br>
                            <p> Nous nous preoccupons de la sécurité de votre compte. Pour nous aider, il est impératif de ne communiquer à
                            personne votre mot de passe.</p> <br>
                            Toute l'équipe de JacquardBourse vous souhaite la bienvenue ! <br>
                            Prenez soin de vous ! <br>
                            Respectueusement, <br>
                            Equipe de JacquardBourse
                        </div>
                    </body
                </html>
                """
            # C'est l'un ou l'autre qui sera envoyer en fonction des propriétés du serveur.
            msg.attach(text_content)
            msg.attach(html_content)
            smtp.send_message(msg)  # Pour envoyer enfin le mail
            if msg.is_sended():
                smtp.quit() #Pour quiter le serveur
            else:
                print("Impossible d'envoyer un mail pour le moment.")
    else:
        print("Adresse mail introuvable. Veillez réessayer ultérieurement !")
finally:
    if connection.is_connected():
        connection.close()
