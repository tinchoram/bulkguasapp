'''
Created on 11 jul. 2019

@author: Tinchoram
Name: BulkGuasapp
Version 0.1 - Funcionalidad inicial
Version 0.2 - Conexion a la DB
Version 0.3 - add store db
Version 1.0 - Initial version -20191105 - Monte Grande, Buenos Aires, Arg.
Version 1.1 - Correccion de bug - add send_media
Version 1.2 - Aumento de tiempo de espera sendmendia
Version 2.0 - Send Image OK
'''
# -*- coding: utf-8 -*-
from time import sleep
from selenium.webdriver.common.by import By
from selenium import webdriver
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait
from connections import db as conn
import socket
import sys
import os
import os.path as path



############### Login ###################


def login(loginid):
    try:
        db = conn.conectDB()
        cursor = db.cursor()
        cursor.execute("call CheckUser(%(usr)s);", {"usr": loginid})

        row = cursor.fetchone()
        
        if (row):
            print("    Usuario OK")
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
        db = conn.conectDB()
        cursor = db.cursor()
        cursor.execute("call ObtenerLista(%(usr)s);", {"usr": userid})
        lista = cursor.fetchall()
        return lista
       
    
    # desconecta del servidor
        db.close()
    except:
        print("error al obtener lista")
        
############### OBTENGO MSJ con  USERID ###################        

def ObtenerMensaje(userid):
    try:
        db = conn.conectDB()
        cursor = db.cursor()
        cursor.execute("call ObtenerMensaje(%(usr)s);", {"usr": userid})
        row = cursor.fetchone()
        return row[0]
           
    # desconecta del servidor
        db.close()
    except:
        print("error al obtener Mensaje")
        sys.exit()
        
############### OBTENGO Media Path con  USERID ###################        

def ObtenerMedia(userid):
    try:
        db = conn.conectDB()
        cursor = db.cursor()
        cursor.execute("call ObtenerMedia(%(usr)s);", {"usr": userid})
        row = cursor.fetchone()
        return row[0]
           
    # desconecta del servidor
        db.close()
    except:
        print("error al obtener Mensaje Media")
        sys.exit()   
        
##################Verifico que exista media y este en la mida carpeta#########################

def CheckMedia(filepath):
    try:
        if path.exists(filepath):
            print("    Archivo Multimedia OK")
            return True
        else:
            print("El archivo NO MULTIMEDIA se encuentra en la carpeta de envio")
            return False 
    except:
        print("Error al verificar Media File")
        input()
        sys.exit()
     
        
############### Marco inicio de lote en DB ###################

def Iniciarlotedb(userid):
    try:
        db = conn.conectDB()
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
        db = conn.conectDB()
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

#####Verified presense element########
def element_presence(by, xpath, time):
    element_present = EC.presence_of_element_located((By.XPATH, xpath))
    WebDriverWait(driver, time).until(element_present)

#####Verified Connection########

def is_connected():
    try:
        # conectarse al host: nos dice si el host es en realidad
        # accesible
        socket.create_connection(("www.google.com", 80))
        return True
    except:
        is_connected()


#####start Driver########
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


##################send only text#########################

def send_whatsapp_msg(phone_no, msgtext):
    try:
        print("    Abrimos URL")
        driver.get("https://web.whatsapp.com/send?phone={}&text={}".format(phone_no,msgtext))
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

##################send Image#########################

def send_whatsapp_msg_media(phone_no, msgtext,filepath):
    try:
        print("    Abrimos URL")
        driver.get("https://web.whatsapp.com/send?phone={}&text={}".format(phone_no,msgtext))
        
        print("    Espero carga de chat")
        sleep(15)
        element_presence(By.XPATH, '//*[@id="main"]/footer/div[1]/div[2]/div/div[2]', 30)
        
        print("    Cargando archivo Multimedia")
        
        print("    voy attach")        
        element_presence(By.XPATH, '//*[@id="main"]/header/div[3]/div/div[2]/div', 30)
        attachment_box = driver.find_element(By.XPATH, '//*[@id="main"]/header/div[3]/div/div[2]/div')
        attachment_box.click()
        
        print("    Cargando Path archivo")
        filepath = os.getcwd()+'\\'+filepath
        print(filepath)
        element_presence(By.XPATH, '//*[@id="main"]/header/div[3]/div/div[2]/span/div/div/ul/li[1]/button/input[@type="file"]', 30)
        image_box = driver.find_element_by_xpath('//*[@id="main"]/header/div[3]/div/div[2]/span/div/div/ul/li[1]/button/input[@type="file"]')      
        
        print("    voy a enviar ")
        image_box.send_keys(filepath)

        print("    Duermo 3 antes de OK")
        sleep(3)
        send_button = driver.find_element_by_xpath('//span[@data-icon="send-light"]')
        send_button.click()
        
        print("    Espero 5 antes de enviar de nuevo")
        sleep(5)
    except: 
        print("error al abrir URL envio")

##################MAIN#########################

##########Verifico user########################
print("-----------------------------") 
print("BIENVENIDO a BULKGUASAPP v2.0")
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
print("    Mensaje: "+msgtext)
filepath = ObtenerMedia(IDuser)
print("    Imagen: "+filepath)
if(filepath):
    print("    Verificando archivo Multimedia ")
    if not (CheckMedia(filepath)):
        input()
        sys.exit()
else:
    print('    No hay path - solo se envia texto')    
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
        if row[0]:
            print("    con nickname")
            nickname=row[0]   
            msgtosend = nickname+' '+msgtext            
        else:
            print("    sin nickname")
            msgtosend = msgtext
        
        if(filepath!=''):
            print("    voy a enviar msj Multimedia")
            send_whatsapp_msg_media(row[1], msgtosend,filepath)
        else:
            print("    voy a enviar solo texto")    
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