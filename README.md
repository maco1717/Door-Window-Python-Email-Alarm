# SmartDoor


Create a door alarm with a Raspberry Pi.

This is application is a full stack, that reads an input from the RPI GPIO as a magnetic door sensor it send and email notification/alarm when the door has been open. The email alarm can be switched on/off via a WebUI with a button.

The process to detect and handle the interruption and send the emails notification of the event is a python script, that comunicates via a bash websocket server using websocketd, the websocket application is used to create a manager front-end WebUI to enable/disable the email alerts.

The front-end is uses boostrap javascrip jquery, one the back end we use php with nginx and mysql but it can run on any other web server type stack on-device, on-premise or on the cloud.

Extra functionality is the posibility to create a timeline with the times when where door was open and close and a programable timer that notifies if the door has been open for more than some choosen time.

Application Stack:
![smartDoor Stack](https://lh3.googleusercontent.com/-eS_gmuHFmh0/V5cMVSXL_VI/AAAAAAAAOBA/0yW3_tJ7MmUzcG0SJDcIWlD0T-9Ha1e8QCLcB/s0/stack.png "SmartDoor Stack")


-----------------------------------------------------------




Getting started
-----------------------------------------------------------
Dependencies
-----------------------------------------------------------
Install
-----------------------------------------------------------

Documentation
-----------------------------------------------------------

 **StackEdit**[^stackedit].  **Utils**  <i class="icon-cog"></i> **Settings**

-----------------------------------------------------------
TODO:
-----------------------------------------------------------
 - Create Documentation
	 - Document the Code
	 - README.md
	 - Wiki
 - Android client app
 - Event Timeline
 - Add Sensor End-Points
	 - Particle Core (Spark Core)
	 - Arduino MRK1000
