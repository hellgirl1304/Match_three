#Скрипт, который проверяет, появился ли в релизе новый сет, данных о котором в базе еще нет
#Если да, то заполняет данные о нем в базу

#Шикарный скрипт! Залил данные в базу по всем сетам, все их карты. Не трогать, пока работает!


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
def ConnectDB ():
	#Host - пока такой, ибо мы на локалхосте, иначе надо прописать хост
	connection = pymysql.connect(host='127.0.0.1',
                             user='mysql',
                             password='mysql',                             
                             db='mtg',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)
	print ("connect successful!!")
	return connection
	
def CutPrice (price):
	if (len(str(price)) > 15):
		price = round(float(str(price)[15:-1])*60)
	else :
		price = "Не определено"
	return price
	
def getAllCardOneSet (code, connection):
	#Получить все карты одно сета
	url = 'https://www.mtgjson.com/json/'+code+'.json'
	response = requests.get(url)
	resp = response.json()
	jstr = resp['cards']
	for card in jstr:
		if card.get('frameEffect') != "extendedart":
			name = card['name']
			uuid = card['uuid']
			#price = card['prices']['paper']
			forD = card['foreignData']
			Runame = ""
			for lang in forD:
				if lang.get('language') == "Russian":
					Runame = lang['name']
					#getPrice(Runame, name, price, string)
			insertNewCard(connection,name,Runame,uuid,code)

	#return resp

def insertNewCard(connection,name,Runame,uuid,code):
	cursor = connection.cursor()
	SQL = 'INSERT INTO `card_by_set` (`id_card`, `name`, `ru_name`, `set_code`, `uuid`) VALUES (null, %s, %s, %s, %s)'
	#cursor.execute("INSERT INTO `card_by_set` (`id_card`, `name`, `ru_name`, `set_code`, `uuid`) VALUES (null, '%s', '%s', '%s', '%s')" %(name,Runame, code,uuid))
	cursor.execute(SQL, (name,Runame, code,uuid))
	try:
		#print (name)
		#print (Runame)
		connection.commit()
	except Exception as err:
		print(err)
		#print (name)

def insertNewSet(connection,name,code,releaseDate):
	cursor = connection.cursor()
	print(code)
	SQL = 'INSERT INTO `set_list` (`name`, `releaseDate`, `code`) VALUES (%s, %s, %s)'
	cursor.execute(SQL,(name,releaseDate, code))
	try:
		connection.commit()
	except Exception as err:
		print(err)

#Сравниваем каждый из выпущенных сетов, есть ли такой в базе
def selectSetOld(connection, data, now):
	cursor = connection.cursor()
	# Проверка каждого сета
	for set in data:
		isOnlineOnly = str(set['isOnlineOnly'])
		releaseDate = datetime.datetime.strptime(set['releaseDate'], "%Y-%m-%d")
		cursor.execute("SELECT name from set_list where name=%s",set['name'])
		try:
			oldData = cursor.fetchone()
			# Делаем запрос в базу по имени этого сета
			if (oldData == None and isOnlineOnly.lower() != "true" and releaseDate<now):
				#Не нашли
				releaseDate = str(releaseDate)[:10]
				insertNewSet(connection,set['name'],set['code'],releaseDate)
				getAllCardOneSet(set['code'], connection)
		except Exception as err:
			print(err)
			input()
	connection.close()
 


# загружаем json файл
now = datetime.datetime.now()
print(now)
data = getAllSet()
#csv_writer(data, now)
connection = ConnectDB()
selectSetOld(connection, data, now)
print("All done")
input()

