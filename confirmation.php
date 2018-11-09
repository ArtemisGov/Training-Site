<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "RS");
if (mysqli_connect_errno()) {
  print("Connect failed: %s\n" . mysqli_connect_error());
  exit();
}
$activated = "";
if (isset($_SESSION["name"])) {
  $nome = $_SESSION["name"];
  $un_pass = $_SESSION["session"];
  $userQuery = "SELECT realUsername, sessionID FROM authentication WHERE realUsername='" . $nome . "' ORDER BY id DESC LIMIT 1;";
  $userResponse = @mysqli_query($mysqli,$userQuery);
  $userRow = @mysqli_fetch_array($userResponse);
  $hash = $userRow['sessionID'];
  if(password_verify($un_pass, $hash)) {
    $sucesso = "yes";
  }
}
$ip = $_SERVER["REMOTE_ADDR"];
$yay = "";
$pseuRand = "";
$cIP = "";
if (isset($_GET['code'])) {
  $code = $_GET['code'];
  $code = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($code))))));
}

if(isset($_POST['submit'])) {
  $authCountQuery = "SELECT COUNT(id), ip FROM authentication WHERE ip = '" . $ip . "' AND type='login' AND success = '0' AND timestamps >= DATE_SUB(NOW(),INTERVAL 1 HOUR);";
  $authCountRes = @mysqli_query($mysqli,$authCountQuery);
  $authCountRow = @mysqli_fetch_array($authCountRes);
  $authCount = $authCountRow['COUNT(id)'];
  if ($authCount < 5) {
    $password = $_POST['password'];
    $password = strrev($password);
    $username = $_POST['fname'];
    $username = strtolower($username);
    $username = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($username))))));
    $userQuery = "SELECT usrid, username, password, active, confirmation FROM userinfo WHERE username='" . $username . "';";
    // ISSUE: Does not find latest. Finds oldest. Truncate it to test.
    $userResponse = @mysqli_query($mysqli,$userQuery);
    $userRow = @mysqli_fetch_array($userResponse);
    $name = $userRow['username'];
    $confirmation = $userRow['confirmation'];
    $active = $userRow['active'];
    if ($active == 1) {
      header("Refresh:0; url=index.php");
    }
    $hashed_password = $userRow['password'];
    $usrid = $userRow['usrid'];
    $hashed_password = substr($hashed_password, 7);
    $hashed_password = strrev($hashed_password);
    if(password_verify($password, $hashed_password)) {
      $yay = "Success!";
    } else {
      $yay = "Fail!";
    }


    if ($name == $username) {
      $success = "1";
    } else {
      $success = "0";
    }
  $sql = "INSERT INTO authentication (usrid, realUsername, ip, reqUsername, success, type) VALUES ('" . $usrid . "', '" . $name . "', '" . $ip ."', '" . $username ."', '" . $success ."', 'activ');";
  mysqli_query($mysqli,$sql);
} else {
  $yay = "You've made too many attempts. -_- Try later. ";
}

  if ($yay == "Success!") {
    if ($confirmation == $code) {
      $activate = "UPDATE userinfo SET active = '1', confirmation = '' WHERE usrid='" . $usrid . "';";
      mysqli_query($mysqli,$activate);
      $activated = "yes";
      $correctMSG = "You account has been activated";
      header("Refresh:15; url=login.php");
    }
  }

}

if (isset($sucesso) == "yes") {
  //header("Refresh:0; url=index.php");
} else {
echo '
<html>
<head>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
  <title>
    Login
  </title>
<style>
html, body {
  margin: 0px;
  background-color:  #F5F5F5;
}
.dropdown-content {
  transition: visibility .1s ease-in-out .001s;
  visibility: hidden;
  width: 200px;
  position: fixed;
  background-color: white;
}
#login {
  max-width: 500px;
  background-color: white;
  padding: 20px;
  position: relative;
  height: 500px;
}
#login #loginFooter {
  position: absolute;
  bottom: 2;
  left: 0;
  float: left;
  margin-left: 20px;
}
label {
  float: left;
  margin-top: 2px;
}


  #menu {
      transition: top .1s ease-in-out;
      width: 100vw;
      color: white;
      height: 100px;
      background-color: #34a844;
      top:'; if ($activated == "") { echo '-90px;'; } else { echo '0px;'; }
echo 'position: absolute;
	text-align: center;
line-height: 90px;
      transition: top .1s ease-in-out;
    }';
echo '</style>';

}







if (isset($sucesso) == "yes") {

} else {
echo '
</head>
<body>
<div id="menu">';
if ($activated == yes) {
	echo $correctMSG;
}
echo '</div> <br /><br /><br /><br /><br /><br />
<center>
  <div id="login">
    <br />
    <h3> Confirm your credentials </h3>
    <form method="POST">
      <br />
        <label> Username </label> <input type="text" class="form-control" name="fname"><br />
        <label> Password </label> <input type="password" class="form-control" name="password"><br />
        <input type="submit" value="Submit" name="submit" class="btn btn-primary">
    </form>
    <span id="loginFooter">
      <a href="register.php">
         Register
      </a>
    </span>

    <!-- <?php // echo $cIP; ?> -->
  </div>
</center>
</body>
</html>';
}
 ?>
