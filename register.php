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
<!DOCTYPE html>
<html>
<head>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
  <title>
    Register
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
#login {
  max-width: 500px;
  background-color: white;
  padding: 20px;
  position: relative;
  height: 500px;
}
#login #loginFooter {
  bottom: 2;
  left: 0;
  vertical-align: bottom;
  float: left;
  margin-left: 20px;
}
label {
  float: left;
  margin-top: 2px;
}
input {
  float: right;
}
.l {
  margin-top: 10px;
  width: 100%;
}
</style>
';
}

error_reporting(E_ALL);

$error = "";
$success = "";
    if(isset($_POST['submit'])) {
      //$sqlq = $mysqli->prepare("INSERT INTO userinfo (username, password) VALUES (:name, :password)");
      //$sql = $mysqli->prepare($sqlq);
      //$sql->bindValue(':name', $name);
      //$sql->bindValue(':password', $hashed_password);

      //$sqlq = $mysqli->prepare("INSERT INTO userinfo (username, password) VALUES (?, ?)");
      //$sqlq->bind_param("sss", $username, $password);

      $email = $_POST['email'];
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
      }
      $email = str_replace("@","Ѫ",$email);
      $email = trim(preg_replace('/ +/', ' ',urldecode(html_entity_decode( strip_tags($email)))));
      $email = strtolower($email);

      $password2 = $_POST['password2'];
      $name = $_POST['fname'];
      $password = $_POST['password'];
      $password2 = $_POST['password2'];
      $password = $_POST['password'];
      $name = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($name))))));
      $namaeLen = strlen($name);
      $name = strtolower($name);
      $userQuery = "SELECT username FROM userinfo WHERE lower(username)='" . $name . "';";
      $userResponse = @mysqli_query($mysqli,$userQuery);
      $userRow = @mysqli_fetch_array($userResponse);
      $username = $userRow['username'];
      $username = strtolower($username);
      if ($namaeLen < 4 or $namaeLen > 20) {
        $error = "Please choose a name over 4 or less than 20 chars";
      } elseif ($username != NULL or $username != 0) {
         $error = "Name already in use";
      //} elseif ($password < 7 or $password > 100) {
        // Displaying when not supposed to. Blocks all.
        //$error = "Please use a password longer than 7 chars";
      } elseif ($username == NULL or $username == 0) {
        if ($password != $password2) {
          $error = "Passwords do not match";
        }
      } else {
        $error = "Unknown error";
      }
      if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password)) {

      } else {
        $error = "Please use at least one letter or number";
      }
      $password = strrev($password);
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $hashed_password = strrev($hashed_password);
      $hashed_password = "$01\$y2$".$hashed_password;
      if ($error == "") {
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < 129; $i++) {
          $rand = mt_rand(0, $max);
          $pseuRand .= $characters[$rand];
        }
        $sql = "INSERT INTO userinfo (username, password, email, confirmation) VALUES ('" . $name . "', '" . $hashed_password . "',  '" . $email . "',  '" . $pseuRand . "');";
        mysqli_query($mysqli,$sql);

        $email = str_replace("Ѫ","@",$email);

        $subject = 'Artemis Confirmation Email';
        $message = 'MAKE CONFIRMATION LINK & PUT HERE. HTML MAY ALSO BE PLACED HERE. <a href="https://gov.artemisrepublic.co/confirmation.php?code=' . $pseuRand . '"> click </a>';
        $headers = 'From: info@artemisrepublic.co' . "\r\n" .
        'Reply-To: info@artemisrepublic.co' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        mail($email, $subject, $message, $headers);
        $success = "Success! Check your email for confirmation. It may take up to 20min.";
        header("Refresh:20; url=login.php");
    }
  }


if (isset($sucesso) == "yes") {

} else {
echo '
<script>
  $(document).ready(function() {
      $("#menu").load("menu.php");
    });
</script>
</head>
<body>
  <span id="menu"></span>
<br /><br /><br /><br /><br /><br />
<center>
  <div id="login">
    <br />
    <h3> Register </h3>
    <form method="POST">
      <br />
        <label> Username </label> <input type="text" class="form-control" name="fname"><br /><br />
        <label> Email </label> <input type="text" class="form-control" name="email"><br /><br />
        <label> Password </label> <input type="password" class="form-control" name="password"><br /><br />
        <label> Confirm Password </label> <input type="password" class="form-control" name="password2"><br /><br />
        <input type="submit" value="Submit" name="submit" class="btn btn-primary l">
    </form>';
    echo '<span id="loginFooter">
      <a href="login.php">
         Login
      </a> ' . $success . ' ' . $error . '
    </span>
  </div>
</center>
</body>
</html>';
}
?>
