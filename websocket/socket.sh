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
  var=$(</home/pi/websocketd/var)
  echo "$var"
  read -t 0.01 input
  input=${input:-$var}
  if [ "$input" != "$var" ]
  then
    echo "$input" > "/home/pi/websocketd/var"
    #echo "$(date) Email alert service changed" $input >> "/home/pi/websocketd/socket.log"
  fi
  #echo $input
	#echo "$input" > "/home/pi/websocketd/var"
  #sleep 1
done
