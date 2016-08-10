#!/bin/bash
### BEGIN INIT INFO
# Provides: run.sh Required-Start: $remote_fs $syslog Required-Stop: 
# $remote_fs $syslog Default-Start: 2 3 4 5 Default-Stop: 0 1 6 
# Short-Description: DoorEventHandler and websocketd Description: This 
# file should be used to construct scripts to be
#                    placed in /etc/init.d.  This example start a single 
#                    forking daemon capable of writing a pid file.  To 
#                    get other behavoirs, implemend do_start(), 
#                    do_stop() or other functions to override the 
#                    defaults in /lib/init/init-d-script.
### END INIT INFO
# Author: Marco Phillips <foobar@baz.org>
#
#
#
python /home/pi/process/server.py > /home/pi/log/start.log 2>&1 & 
/home/pi/websocket/websocketd --port=8000 /home/pi/websocket/socket.sh > 
/home/pi/log/start.log 2>&1 &
