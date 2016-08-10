<?php
session_start();
include_once 'Dbconnect.php';
//check if form is submitted
if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($con, $_POST['user_email']);
    $password = mysqli_real_escape_string($con, $_POST['user_pwd']);
    $result = mysqli_query($con, "SELECT * FROM users WHERE user_email = '" . $email. "' and user_pwd = '" . md5($password) . "'");

    if ($row = mysqli_fetch_array($result)) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_name'] = $row['user_name'];
        header("Location: index.php");
    } else {
        $errormsg = "Incorrect Email or Password!!!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Alarma Puerta eMail</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
    <!-- Button -->
    <link rel="stylesheet" href="style2.css">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
            <div  style="font-family:FontAwesome; float:left; padding-top:1px">&#xF013;&nbsp;</div>
            <div style="float:left">Panel de Control</div>
          </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <!-- <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          -->
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php if (isset($_SESSION['user_id'])) { ?>
            <li><p class="navbar-text">&nbsp;Usuario: <?php echo $_SESSION['user_name']; ?></p></li>
            <li><a href="Logout.php">Salir</a></li>
            <!--<?php // } else { ?>
            <li><a href="index.php">Acceder</a></li>-->
            <?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

<?php
    if(isset($_SESSION['user_id'])!="") {
?>
<div class="container">
  <div class="starter-template">
    <div class="starter-template">
      <h1 style="color:silver"><div>Enviar email<a href="#" style="margin:auto" id="button" class="new" status="">&#xF011;</a></div></h1>
    </div>
  </div>
</div><!-- /.container -->


 <!-- Button jquery-->
 <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
 <script type="text/javascript">
 // Connection Information console
 function log(msg) {
   document.getElementById('log').textContent += msg + '\n';
 }


 // setup websocket with callbacks
 var ws = new WebSocket('ws://192.168.1.143:8000/');
 // Connection handler
 ws.onopen = function() {
   var connected = "no"
 };
 ws.onclose = function() {
   var ws_connection_status = "no";
   Visibility(ws_connection_status);
 };
 // Incoming
 ws.onmessage = function(event) {
   if (event.data == "off"){
     document.getElementById("button").setAttribute("status", "off");
     document.getElementById("button").setAttribute("class", "new")
   }
   else{
     document.getElementById("button").setAttribute("status", "on");
     document.getElementById("button").setAttribute("class", "new on")
   }
 };
 // Visibility
 function Visibility(ws_connection_status){
 var content = document.getElementsByClassName("container")[1];
 // get the current value of the content display property
 var displaySetting = window.getComputedStyle(content, null).getPropertyValue("display");;
 // now toggle the container, depending on current state
 if (ws_connection_status === "no") {
   document.getElementsByClassName("container")[1].style.display = "none";
   document.getElementsByClassName("info")[0].style.display = "block";
   log("DESCONECTADO!");
 }
 else {
   document.getElementsByClassName("container")[1].style.display = "block";
   document.getElementsByClassName("info")[0].style.display = "none";
 }
 }
 // Set status and button
 function write(status){
   if (status == "off"){
     document.getElementById("button").setAttribute("status", "off");
     document.getElementById("button").setAttribute("class", "new")
   }
   else{
     document.getElementById("button").setAttribute("status", "on");
     document.getElementById("button").setAttribute("class", "new on")
   }
 }
 // On click chage button
 $(document).ready(function(){
   $('#button').on('click', function(){
     $(this).toggleClass('on');
     if (document.getElementById("button").getAttribute("class") === "new"){
       new_status = "off"
       ws.send(new_status);
     }else{
       new_status = "on"
       ws.send(new_status);
     }
   });
 });
 </script>


<?php
    }
    else{
 ?>
      <div class="container" style="padding-top:10px">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 well">
                    <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
                        <fieldset>
                            <legend>Acceder</legend>

                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="text" name="user_email" placeholder="Email" required class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="name">Contraseña</label>
                                <input type="password" name="user_pwd" placeholder="Contraseña" required class="form-control" />
                            </div>

                            <div class="form-group">
                                <input type="submit" name="login" value="Login" class="btn btn-primary" />
                            </div>
                        </fieldset>
                    </form>
                    <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
                </div>
            </div>
      </div><!-- /.container -->



 <?php
     }
  ?>

  <div class="starter-template">
    <!-- Conection? -->
    <pre id="log" class="info" style="display: none"></pre>
  </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
