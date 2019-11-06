'''
Created on 11 jul. 2019

@author: Tinchoram
Name: BulkGuasapp
GNU General Public License v3.0 o superior
Source: https://github.com/tinchoram/bulkguasapp
Version 0.1 - Funcionalidad inicial
Version 0.2 - Conexion a la DB
Version 0.3 - add store db
Version 1.0 - Initial version -20191105 - Monte Grande, Buenos Aires, Arg.
'''
# -*- coding: utf-8 -*-
from time import sleep
from selenium.webdriver.common.by import By
from selenium import webdriver
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait
import socket
import pymysql
import sys
import os
import os.path as path

############### DB connection ###################

def conectDB():
    try:
        return pymysql.connect("localhost","bulk","password","todxs")
        
    except:
        print("Error al conectar con la DB")   


############### Login ###################


def login(loginid):
    try:
        #print(loginid)
        db = conectDB()
        cursor = db.cursor()
        cursor.execute("call CheckUser(%(usr)s);", {"usr": loginid})

        row = cursor.fetchone()
        
        if (row):
            print("    Usuario OK") 
            #print(row[0])
            return row[0]
        else:
            print("El usuario no eta activo o no existe, contacte con Tinchoram.com")    
            return 0
        db.close()
    except:
        print("Error al verificar usuario")
        input()
        sys.exit()  
         
############### OBTENGO LISTADO ###################


def obtenerlista(userid):
    try:
        db = conectDB()
        cursor = db.cursor()
        #cursor.execute("call ObtenerLista(8)")
        #print(userid)
        cursor.execute("call ObtenerLista(%(usr)s);", {"usr": userid})
        lista = cursor.fetchall()
        return lista
       
    
    # desconecta del servidor
        db.close()
    except:
        print("error al obtener lista")
        
############### OBTENGO USERID ###################        

def ObtenerMensaje(userid):
    try:
        db = conectDB()
        cursor = db.cursor()
        cursor.execute("call ObtenerMensaje(%(usr)s);", {"usr": userid})
        row = cursor.fetchone()
        return row[0]
           
    # desconecta del servidor
        db.close()
    except:
        print("error al obtener Mensaje")
        
############### Marco inicio de lote en DB ###################

def Iniciarlotedb(userid):
    try:
        db = conectDB()
        cursor = db.cursor()
        #cursor.execute("call ObtenerMensaje(8)")
        cursor.execute("call MarcarInicioLote(%(usr)s);", {"usr": userid})
        db.commit()
        print("    Lote iniciado")                      
        # desconecta del servidor
        db.close()
    except:
        print("error al marcar lote en db")


############### Marco Fin de lote en DB ###################

def Terminarlotedb(userid):
    try:
        db = conectDB()
        cursor = db.cursor()
        #cursor.execute("call ObtenerMensaje(8)")
        cursor.execute("call MarcarFinLote(%(usr)s);", {"usr": userid})
        db.commit()
        print("    Lote finalizado")           
    # desconecta del servidor
        db.close()
    except:
        print("error al marcar lote en db")      
     
############### Web Driver ###################       

def element_presence(by, xpath, time):
    element_present = EC.presence_of_element_located((By.XPATH, xpath))
    WebDriverWait(driver, time).until(element_present)

def is_connected():
    try:
        # conectarse al host: nos dice si el host es en realidad
        # accesible
        socket.create_connection(("www.google.com", 80))
        return True
    except:
        is_connected()

def startDriver():
    try:
        if path.exists("chromedriver.exe"):
            print("    Iniciando driver")
            return webdriver.Chrome(executable_path="chromedriver.exe")
        else:
            print("El driver no se encuentra en la misma carpeta")
            input()
    except:
        print("Error al iniciar driver")
        input()

def send_whatsapp_msg(phone_no, msgtext):
    try:
        print("    Abrimos URL")
        #print("https://api.whatsapp.com/send?phone={}&text={}".format(phone_no,msgtext))
        #driver.get("https://api.whatsapp.com/send?phone={}&text={}".format(phone_no,msgtext))
        #https://web.whatsapp.com/send?phone=54911xxxxxxxx&text=tinchoramesto+es+un+msj+de+prueba
        driver.get("https://web.whatsapp.com/send?phone={}&text={}".format(phone_no,msgtext))
        #print("Abri URL acepto el envio")
        #user = driver.find_element_by_id('action-button')
        #user.click()
        print("    Duermo 5 para carga de chat")
        sleep(5)
        element_presence(By.XPATH, '//*[@id="main"]/footer/div[1]/div[2]/div/div[2]', 30)
        txt_box = driver.find_element(By.XPATH, '//*[@id="main"]/footer/div[1]/div[2]/div/div[2]')
        print("    Duermo 3 antes de OK")
        sleep(3)
        txt_box.send_keys("\n")
        print("    Espero 5 antes de enviar de nuevo")
        sleep(5)
    except: 
        print("error al abrir URL envio")

##################MAIN#########################

##########Verifico user########################
print("-----------------------------") 
print("BIENVENIDO a BULKGUASAPP v1.0")
print("-----------------------------")  
print("Ingrese Usuario: ") 
loginid= input()
print('Validando user: ' + loginid)
IDuser=login(loginid)
if(IDuser==0):
    input()
    sys.exit()
    
##########Obtengo lote activo####################
print ("---INICIO ENVIO---")
print("1- Obteniendo lotes Activos")

number_list=obtenerlista(IDuser)
if not (number_list):
    print("    La lista esta vacia")
    input()
    sys.exit() 
else:
    print("    Lista de contactos preparada OK")


print("2- Obteniendo el mensaje a enviar")
msgtext= ObtenerMensaje(IDuser)
print("    Mensaje: ")
print(msgtext)
print("3- Iniciando lote db")
Iniciarlotedb(IDuser)
print("4- Iniciando chromedriver")
driver=startDriver()
driver.get("http://web.whatsapp.com")
print("5- por favor escanee el codigo QR")
print("    Espero 20 seg para escaneo QR")
sleep(20)  # esperar tiempo para escanear el c�digo en segundo

print("6- inicio envio web")
    
for row in number_list:
    try:
        msgtosend = ''
        print ("    Preparando envio para {} al numero {}".format(row[0],row[1]))
        nickname=row[0]
        msgtosend = nickname+' '+msgtext
        send_whatsapp_msg(row[1], msgtosend)

    except Exception as e:
        sleep(10)
        is_connected() 

print("    Se finalizo el envio")
print("7- Cerrando Chrome")
driver.close()
print("8- finalizando lote db")
Terminarlotedb(IDuser)
print ("-------------------")
print ("---FIN DE ENVIO---")
print ("Gracias, vuelva pronto...")
print ("-------------------")
print ("by tinchoram.com")
input()
sys.exit() 