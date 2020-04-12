#Скрипт, который проверяет, появился ли в релизе новый сет, данных о котором в базе еще нет
#Если да, то заполняет данные о нем в базу

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

# Подключиться к базе данных.
def ConnectDataBase (data, now):
	#Host - пока такой, ибо мы на локалхосте, иначе надо прописать хост
	connection = pymysql.connect(host='127.0.0.1',
                             user='mysql',
                             password='mysql',                             
                             db='mtg',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)
	cursor = connection.cursor()
	cursor.execute("SELECT * from set_list")
	try:
		oldData = cursor.fetchall()
		for row in oldData:
			print(row['name'])
			for set in data:
				isOnlineOnly = str(set['isOnlineOnly'])
				releaseDate = datetime.datetime.strptime(set['releaseDate'], "%Y-%m-%d")
				if (isOnlineOnly.lower() != "true" and releaseDate<now and str(row['name'])!=str(set['name'])):
					print(set['name'])
		print ("All done")
	except Exception as err:
		print(err)
	connection.close()
 
	print ("connect successful!!")

# Подключиться к базе данных.
def ConnectDB (data, now):
	#Host - пока такой, ибо мы на локалхосте, иначе надо прописать хост
	connection = pymysql.connect(host='127.0.0.1',
                             user='mysql',
                             password='mysql',                             
                             db='mtg',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)
	cursor = connection.cursor()
	for set in data:
		print(set['name'])

	connection.close()
 
	print ("connect successful!!")


# загружаем json файл
now = datetime.datetime.now()
print(now)
data = getAllSet()
#csv_writer(data, now)
ConnectDB(data, now)
input()

