#!/usr/bin/python
#import modules
import threading

import time
import datetime

import logging
import os.path

import RPi.GPIO as GPIO

import smtplib
from email.MIMEMultipart import MIMEMultipart
from email.MIMEText import MIMEText

import json

import pyinotify

import sys

# logging
logging.basicConfig(filename="/home/pi/test0.log",level=logging.DEBUG,format='%(asctime)s - (%(threadName)-9s) - %(message)s',)
#logging.basicConfig(level=logging.DEBUG,format='%(asctime)s - (%(threadName)-9s) - %(message)s',)

logging.getLogger().addHandler(logging.StreamHandler())

#variables#
#Files
#email_alarm_status var location
#log location
#log events
#json data
#WebSocket server ('ws://192.168.1.140:8000/');

#email
global email_alarm_status
email_alarm_status = ""
#global new_email_alarm
#email_alarm_status = ""

#vis.js
global event_logging_status
event_logging_status = "off"

#timer
global countdown_notify_status
countdown_notify_status = "off"
global door_countdown
global count
count = 1
timer = 1
countdown = 5

#Door Sensor
global sensor
#button = False
global Input
Input = 23 # data pin of Input sensor (in)

# GPIO setup
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
GPIO.setup(Input, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)

### Start
class NullDevice():
    def write(self, s):
        pass

def status(argument):
    global email_alarm_status
    #global new_email_alarm

    if not email_alarm_status:
        with open('/home/pi/websocketd/var') as fp:
            email_alarm_status = fp.read()
        with open("/home/pi/websocketd/tempvar","w") as cp:
            cp.write(email_alarm_status)

    with open('/home/pi/websocketd/var') as fp:
        with open("/home/pi/websocketd/tempvar") as cp:
            if cp.read() != fp.read():
                email_alarm_status = fp.read()
                print "changed"
                #logging.debug("Email notification service changed")

def log_event(door):
    ids = 0

    if os.path.isfile("/home/pi/data.json"):
        with open("data.json","r") as outfile:
            datain = json.load(outfile)

        i = datain["Events"]
        for rs in i:
            print "id", rs["id"]
            num = int(rs["id"])
            print "event", datain["Events"][num]
            ids += 1
    #ids = ids - 1
    print "Events", ids

    if door:
        print("Door opened")
        print(datetime.datetime.now().strftime('%Y/%m/%d %H:%M:%S'))
        if os.path.isfile("/home/pi/data.json") and ids >= 1:
            print "door open datain, file>1"
            datain["Events"].append({"content": "Button Pressed", "start": datetime.datetime.now().strftime('%Y/%m/%d %H:%M:%S'), "id": ids })
            print datain
        elif os.path.isfile("/home/pi/data.json") and ids == 0:
            print "door open datain, file 0"
            datain["Events"].append({"content": "Button Pressed", "start": datetime.datetime.now().strftime('%Y/%m/%d %H:%M:%S'), "id": ids })
            print datain
        else:
            dataout = {"Events":[{"content": "Button Pressed", "start": datetime.datetime.now().strftime('%Y/%m/%d %H:%M:%S'), "id": "0" }]}
            print "door open data out", dataout
    if not door:
        print("Door closed")
        print(datetime.datetime.now().strftime('%Y/%m/%d %H:%M:%S'))
        if os.path.isfile("/home/pi/data.json") and ids >= 1:
            print "door closed datain, file>1"
            #print datain["Events"][]
            old_ids = ids - 1
            datain["Events"][old_ids]['end'] = datetime.datetime.now().strftime('%Y/%m/%d %H:%M:%S')
            print datain
        elif os.path.isfile("/home/pi/data.json") and ids == 0:
            print "door closed datain, file 0"
            #dataout = datain
            datain["Events"][0]['end'] = datetime.datetime.now().strftime('%Y/%m/%d %H:%M:%S')
            datain
        else:
            print "door closed no file"
            #dataout = datain
            dataout["Events"][0]['end'] = datetime.datetime.now().strftime('%Y/%m/%d %H:%M:%S')
            print "dataout nofile", dataout

    if os.path.isfile("/home/pi/data.json"):
        with open('data.json', 'wb+') as outfile:
            print "file dump", datain
            json.dump(datain, outfile, sort_keys=False, indent=4)
    else:
        with open('data.json', 'ab+') as outfile:
            print "no file dump", dataout
            json.dump(dataout, outfile, sort_keys=False, indent=4)

def sendmail():
    fromaddr = "email"
    toaddr = "email"
    msg = MIMEMultipart()
    msg['From'] = fromaddr
    msg['To'] = toaddr
    msg['Subject'] = "DoorAlarm - SmartDoor"

    body = "This is a test mail generated with python on a RPi: From SmartDoor"
    msg.attach(MIMEText(body, 'plain'))

    server = smtplib.SMTP('smtp.gmail.com', 587)
    server.starttls()
    server.login("username", "password")
    text = msg.as_string()
    server.sendmail(fromaddr, toaddr, text)
    server.quit()

if "on" in countdown_notify_status:
    def timeout(e, t):
        global count
        global sensor

        while True:
            #logging.debug('timout running')
            while sensor:
                while not e.isSet() and count <= countdown:
                    if count == 1: logging.debug('Door opened - starting counter')
                        #pass
                    event_is_set = e.wait(t)
                    if event_is_set:
                        count = 1
                        logging.debug('Door closed before countdown')
                    else:
                        count += 1
                    if count == countdown:
                        #pass
                        logging.debug('countdown completed - notify')
                        #sendmail()

def handler(channel):
    global sensor
    global count
    global email_alarm_status

    logging.debug('Event detected')
    
    if GPIO.input(Input) == GPIO.LOW:
        time.sleep(0.2)
        if GPIO.input(Input) == GPIO.LOW:
            sensor = True
            e.clear()
            #time.sleep(0.1)
            logging.debug('Door open')
            #logging.debug(email_alarm_status)
            if "on" in email_alarm_status:
                pass
                logging.debug('Door open, email alert sent')
                #sendmail()
                SendEmailThread = threading.Thread(name='EmailAlert', target=sendmail)
                SendEmailThread.start()
            if "on" in event_logging_status:
                log_event(sensor)
            if count != 1:
                logging.debug("Restart countdown")
                count = 1
    else:
        if GPIO.input(Input) == GPIO.HIGH:
            time.sleep(0.2)
            if GPIO.input(Input) == GPIO.HIGH:
                sensor = False
                #time.sleep(0.1)
                e.set()
                logging.debug("Door closed")
                #pass
                if "on" in event_logging_status:
                    log_event(sensor)
                    #log_event(button)

if GPIO.input(23):
	door_status = "Closed"
else:
	door_status = "Open"

logging.debug("The Door is: %s", (door_status))

if __name__ == '__main__':
    e = threading.Event()

    if "on" in countdown_notify_status:
        t = threading.Thread(name='countdown', target=timeout, args=(e, timer))
        t.start()

    t2 = threading.Thread(name='status', target=status, args=(event_logging_status,))
    t2.start()

    logging.debug('Python application start()')
    GPIO.add_event_detect(Input, GPIO.BOTH, callback=handler, bouncetime=300)

    original_stdout = os.dup(sys.stdout.fileno())

    nullfd = os.open("/dev/null", os.O_WRONLY)
    os.dup2(nullfd, sys.stdout.fileno())
    os.close(nullfd)
    ##
    wm = pyinotify.WatchManager()
    notifier = pyinotify.Notifier(wm)
    wm.add_watch('/home/pi/websocketd/var', pyinotify.IN_MODIFY)
    notifier.loop(callback=status)
    ##
    os.dup2(original_stdout, sys.stdout.fileno())
    os.close(original_stdout)
