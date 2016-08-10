#!/bin/bash

#variables#
#Files
#email_alarm_status var location
#log location
#log events
#json data
#python "server" location
#websocket applicatio n location
#socket.sh location for ((COUNT = 1; COUNT <=10; COUNT++))

while true
do
  var=$(</home/pi/var/var)
  echo "$var"
  read -t 0.01 input
  input=${input:-$var}
  if [ "$input" != "$var" ]
  then
    echo "$input" > "/home/pi/var/var"
  fi
done
