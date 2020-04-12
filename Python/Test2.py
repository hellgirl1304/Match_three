import requests
import json
import re

def getPrice(Runame, name, price, string):
	if (string.lower() == Runame.lower() or string.lower() == name.lower()):
		#print(price)
		#price = (str(price)[15:])[]
		price = round(float(str(price)[15:-1])*60)
		f.write(string+" "+str(price)+"\n")
		#print(price)
	

# загружаем json файл 
fh = open('ListCard.json', 'r') #открываем файл на чтение
ListCard1 = json.load(fh)
fh.close();
ListCard = ListCard1['cards']
f = open ('card.txt', 'w')
for oneCard in ListCard:
	string = str((oneCard['name']))
	url = 'https://www.mtgjson.com/json/'+oneCard['set']+'.json'
	#url = 'https://www.mtgjson.com/json/THB.json'
	response = requests.get(url)
	resp = response.json()
	jstr = resp['cards']
	for card in jstr:
		if card.get('frameEffect') != "extendedart":
			name = card['name']
			price = card['prices']['paper']
			forD = card['foreignData']
			for lang in forD:
				if lang.get('language') == "Russian":
					Runame = lang['name']
					getPrice(Runame, name, price, string)
input()