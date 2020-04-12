#Скрипт для создание сым файла со списком сетов, дата релиза которых уже прошла. 
# В csv будет название сета, дата релиза, код

import requests
import json
import re
import pymysql
import csv
import datetime

def getPrice(Runame, name, price, string):
	if (string.lower() == Runame.lower() or string.lower() == name.lower()):
		#print(price)
		#price = (str(price)[15:])[]
		price = round(float(str(price)[15:-1])*60)
		f.write(string+" "+str(price)+"\n")
		#print(price)
		
#Получаем список сетов
def getAllSet ():
	url = 'https://www.mtgjson.com/files/SetList.json'
	response = requests.get(url)
	resp = response.json()
	return resp
#Нас интересуют три параметра: код, название, дата релиза 
#- по ней будем определять, надо ли подкачивать все карты

def csv_writer(data, now):
	try:
		path = 'C:/Users/User/Documents/AllPrintingsCSVFiles/SetList.csv'
		with open(path, "w", newline="") as csv_file:
			writer = csv.writer(csv_file, delimiter=',')
			writer.writerow(['name','releaseDate','code'])
			for set in data:
				isOnlineOnly = str(set['isOnlineOnly'])
				releaseDate = datetime.datetime.strptime(set['releaseDate'], "%Y-%m-%d")
				if (isOnlineOnly.lower() != "true" and releaseDate<now):
					writer.writerow([set['name'],set['releaseDate'],set['code']])
			print ("All done")
	except Exception as err:
		print(err)	
		input()


#Подключение к базе данных
# Подключиться к базе данных.
def ConnectDataBase ():
	#Host - пока такой, ибо мы на локалхосте, иначе надо прописать хост
	connection = pymysql.connect(host='127.0.0.1',
                             user='mysql',
                             password='mysql',                             
                             db='mtg',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)
	cursor = connection.cursor()
	cursor.execute("SELECT * from city")
	try:
		data = cursor.fetchall()
		for row in data:
			print(row['NAME'])
	except Exception as err:
		print(err)
	#print (data)
	# disconnect from server
	connection.close()
 
	print ("connect successful!!")


# загружаем json файл
now = datetime.datetime.now()
print(now)
data = getAllSet()
csv_writer(data, now)
#ConnectDataBase()
input()

