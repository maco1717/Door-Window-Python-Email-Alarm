#!/bin/bash

source EmailDoorAlarm.conf

while true
do
  var=$(<$path_email_alarm_status)
  echo "$var"
  read -t 0.01 input
  input=${input:-$var}
  if [ "$input" != "$var" ]
  then
    echo "$input" > "$path_email_alarm_status"
  fi
done
