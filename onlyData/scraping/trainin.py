import csv
import mysql.connector

with open('employee_file2.csv', mode='w') as csv_file:
    fieldnames = ['emp_name', 'dept', 'birth_month']
    writer = csv.DictWriter(csv_file, fieldnames=fieldnames)

    writer.writeheader()
    writer.writerow({'emp_name': 'John Smith',
                    'dept': 'Accounting', 'birth_month': 'November'})
    writer.writerow({'emp_name': 'Erica Meyers',
                    'dept': 'IT', 'birth_month': 'March'})


import MySQLdb
import csv
import sys
conn = mysql.connector.connect(host="127.0.0.1", user="Bourse", password="December!1234", database="bourses_data")

cursor = conn.cursor()
csv_data = csv.reader(open('dataAbcBourse.csv'))
header = next(csv_data)

print('Importation du fichier csv ...')
for row in csv_data:
    print(row)
    cursor.execute( "INSERT INTO bourse_data VALUES (null,1,%s, %s, %s, %s,%s,%s,%s,%s,%s,%s,%s now())", row)

conn.commit()
cursor.close()
print('Insertions terminées.')