# Bibliotheque permettant la realisation de requetes http
import requests
# Bibliotheque permettant de "parser" du contenu html
from bs4 import BeautifulSoup
# Bibliotheque de connexion a une BDD mysql
import pymysql.cursors
import time

# Fonction d'enregistrement au format csv
def recordToCsv(data):
    # Ouverture du fichier
    f = open("dataAbcBourse.csv", "w")
    # Ligne d'en-tete
    f.write("Nom;Ouverture;Haut;Bas;Volume;Veille;Dernier;Var\n")
    # Parcours du tableau
    for ligne in data:
        f.write(ligne + "\n")
        #print(ligne)
    # Fermeture du fichier
    f.close()

# Fonction d'insertion dans une base de donnees
def recordToBdd(data):
    f = open("dataAbcBourse.csv", "w")
    connection = pymysql.connect(host = 'localhost',
                                user = 'Ténénan',
                                password = 'Pilotedeligne25',
                                db = 'bourses_data',
                                charset = 'utf8',
                                cursorclass = pymysql.cursors.DictCursor)
    cursor = connection.cursor()
    # Parcours du tableau
    for ligne in data:
        dataLigne = ligne.split(';')
        #print(dataLigne)
        sql = "INSERT INTO bourse_data (idBourseData, idBourseName, coursName, ouverture, valeur_h, valeur_b, volume, veille, dernier, Variation)"+"VALUES (NULL, 1,'"+dataLigne[0]+"','"+dataLigne[1]+"','"+dataLigne[2]+"','"+dataLigne[3]+"','"+dataLigne[4]+"','"+dataLigne[5]+"','"+dataLigne[6]+"','"+dataLigne[7]+"');"
        cursor.execute(sql)
        connection.commit()

# ---------------------
# Programme principal :
# ---------------------
while True:
    # Recuperation de la page Web d'ABCBourse au format "String"
    data_abcbourse = requests.get("https://www.abcbourse.com/marches/indice_cac40");
    # Parsage des donnees
    soup = BeautifulSoup(data_abcbourse.text, 'html.parser')
    # Recuperation de la partie <div id="resultZone">...</div> de la page Web
    soupResultZone = soup.find(id="resultZone")
    # Declaration d'un tableau
    tableauData = []
    # Recuperation des tr (ligne d'un tableau) de la resultZone
    for tr in soupResultZone.find_all('tr'):
        ligne = ""
        # Recuperation des td (case d'un tableau) de chaque tr
        #print()

        for td in tr.find_all('td'):
            # enlever l'appostrophe et remplacer les , par des . pour les valeurs
            ligne += ";" +td.text.replace("'", "").replace(",", ".")


        # Suppression du premier ";"
        ligne = ligne[1:]
        # Ajout dans le tableau
        if ligne != "":
            tableauData.append(ligne)
            #pour afficher le tableau dans le terminal 
            #print(ligne)

    # SAUVEGARDE DANS UNE FICHIER CSV
    recordToCsv(tableauData)
    # SAUVEGARDE DANS UNE BDD
    recordToBdd(tableauData)

    time.sleep(900)