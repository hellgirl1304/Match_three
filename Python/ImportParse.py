import requests
import json
import re
import pymysql

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
	for set in resp:
		isOnlineOnly = str(set['isOnlineOnly'])
		if (isOnlineOnly.lower() != "true"):
			print(isOnlineOnly.lower())
			print(set['name'])
			print(set['releaseDate'])м с
			print(set['code'])
#Нас интересуют три параметра: код, название, дата релиза 
#- по ней будем определять, надо ли подкачивать все карты

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
getAllSet()
ConnectDataBase()
input()

