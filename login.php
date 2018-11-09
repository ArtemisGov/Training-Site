<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "RS");
if (mysqli_connect_errno()) {
  print("Connect failed: %s\n" . mysqli_connect_error());
  exit();
}

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

if (isset($sucesso) == "yes") {
  header("Refresh:0; url=index.php");
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
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: white;
  position: fixed;
  z-index: 2;
  top: 0;
  width: 100vw;
}
li {
  float: right;
}
li.left {
  float: left !important;
}
li a {
  display: block;
  color: black;
  text-align: center;
  padding: 17px 10px;
  text-decoration: none;
  font-size: 19px;
}
#Avatarwrapper {
  height: 30px;
  width: 30px;
  border-radius: 50px;
  display: block;
  color: black;
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
</style>
<script>
$(document).ready(function() {
    $("#menu").load("menu.php");
});
</script>';
}


$ip = $_SERVER["REMOTE_ADDR"];
$yay = "";
$pseuRand = "";
$cIP = "";
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
  $userQuery = "SELECT usrid, username, password FROM userinfo WHERE username='" . $username . "';";
  // ISSUE: Does not find latest. Finds oldest. Truncate it to test.
  $userResponse = @mysqli_query($mysqli,$userQuery);
  $userRow = @mysqli_fetch_array($userResponse);
  $name = $userRow['username'];
  $hashed_password = $userRow['password'];
  $usrid = $userRow['usrid'];
  $hashed_password = substr($hashed_password, 7);
  $hashed_password = strrev($hashed_password);
  if(password_verify($password, $hashed_password)) {
    $yay = "Success!";
  } else {
    $yay = "Fail!";
  }
  if ($yay == "Success!") {
    $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < 129; $i++) {
      $rand = mt_rand(0, $max);
      $pseuRand .= $characters[$rand];
    }
    $hashed_key = password_hash($pseuRand, PASSWORD_DEFAULT);
    $_SESSION["name"] = $name;
    $_SESSION["session"] = $pseuRand;
    $_SESSION["usrid"] = $usrid;
  }


if ($name == $username) {
  $success = "1";
} else {
  $success = "0";
}
  $sql = "INSERT INTO authentication (usrid, realUsername, ip, reqUsername, success, sessionID, type) VALUES ('" . $usrid . "', '" . $name . "', '" . $ip ."', '" . $username ."', '" . $success ."', '" . $hashed_key . "', 'login');";
  mysqli_query($mysqli,$sql);
} else {
  $yay = "You've made too many attempts. -_- Try later. ";
}

if ($yay == "Success!") {
  header("Refresh:0; url=index.php");
}
  // Count requests by this IP, then use that to slow and deny requests between randomly generated interval of time
  // $authQ = "SELECT COUNT(id) AS ID, usrid, username, timestamps, ip, reqUsername FROM authentication WHERE ip='" . $ip . "' and timestamps > date_sub(now(), interval 8 minute);";
  // $authR = @mysqli_query($mysqli,$authQ);
  // $authRow = @mysqli_fetch_array($authR);
  // $cIP = $authRow['ID'];
}




if (isset($sucesso) == "yes") {

} else {
echo '
</head>
<body>
<span id="menu"></span>
<br /><br /><br /><br /><br /><br />
<center>
  <div id="login">
    <br />
    <h3> Login </h3>
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
     ' . $yay . '
    <!-- <?php // echo $cIP; ?> -->
  </div>
</center>
</body>
</html>';
}
 ?>
