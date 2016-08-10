# SmartDoor


Create a door alarm that send an email when the door has been opened using with a Raspberry Pi and a magnetic sensor.

This is a full stack application, that reads an input from a magnetic door sensor connected to the RPIs GPIO and it send and email notification/alarm when the door has been open. The email alarm can be switched on/off via a WebUI with a button that uses websockets to update.

The process to detect and handle the interruption and send the emails notification of the event is done via a python script, that comunicates via a bash script websocket server using websocketd, the websocket application is used to create a manager front-end WebUI to enable/disable the email alerts.

The front-end is done using boostrap javascrip jquery, one the back-end we use php with nginx and mysql but it can run on any other web server type stack. on-device, on-premise or on the cloud.

Future functionality is the posibility to create a timeline with the times when the door was open and close and a programmable timer that notifies if the door has been open for more than some choosen time.

Application Stack:
![smartDoor Stack](https://lh3.googleusercontent.com/-eS_gmuHFmh0/V5cMVSXL_VI/AAAAAAAAOBA/0yW3_tJ7MmUzcG0SJDcIWlD0T-9Ha1e8QCLcB/s0/stack.png "SmartDoor Stack")


-----------------------------------------------------------




Getting started
-----------------------------------------------------------
Dependencies
-----------------------------------------------------------
- Web server
	- mysql-server
	- nginx
	- php5-fpm
	- php5-mysql
	- mysql-client
	- php5-cli
	- php-apc
	- phpmyadmin
- Python
	- python-pip
	- pyinotify
- Websocket
	- websocketd

Install
-----------------------------------------------------------

Documentation
-----------------------------------------------------------

-----------------------------------------------------------
TODO:
-----------------------------------------------------------
 - Create Documentation
	 - Document the Code
	 - README.md
	 - Wiki
 - Android client app
 - Event Timeline
 - Create a websocket script using python
 	 - Websocket with a JSON file
 - Add Sensor End-Points
	 - Particle Core (Spark Core)
	 - Arduino MRK1000
