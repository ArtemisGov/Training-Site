<?php
  session_start();
  $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
  if ($lang == "en" or $lang == NULL) {
    $nav = array("Home","About","Jobs","Login", "Contact");
    $slogan = "Learn. Teach. Create.";
    $sloganSubTxt = "Created for Artemis; Designed for Artemis.";
  } elseif ($lang == "pt") {
    $slogan = "Aprende. Ensina. Cria.";
    $sloganSubTxt = "Feito por Artemis; Desenhado para Artemis.";
  } elseif ($lang == "eo") {
    $nav = array("Ĉefpaĝo","Pri Ni","Laboro","Ensaluti", "Kontaktu");
    $slogan = "Lernu. Instruu. Krei.";
    $sloganSubTxt = "Farita por Artemis; Desegnita por Artemis.";
  }

  $mysqli = new mysqli("localhost", "root", "", "RS");
  if (mysqli_connect_errno()) {
    print("Connect failed: %s\n" . mysqli_connect_error());
    exit();
  }
  // Use this for view control
  if (isset($_SESSION["name"])) {
    $nome = $_SESSION["name"];
    $un_pass = $_SESSION["session"];
    $userQuery = "SELECT realUsername, sessionID FROM authentication WHERE realUsername='" . $nome . "' ORDER BY id DESC LIMIT 1;";
    $userResponse = @mysqli_query($mysqli,$userQuery);
    $userRow = @mysqli_fetch_array($userResponse);
    $hash = $userRow['sessionID'];
    if(password_verify($un_pass, $hash)) {
      $success = "Blyat";
    } else {
      $success = "Mission Failed";
    }
  }
  // Include in other pages, block access if not logged in
  // Truncate the authentication table daily.
echo '<!DOCTYPE html>
<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link href="./css/index.css" rel="stylesheet">
<script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
  <title>
    Home
  </title>
<style>
html, body {
  margin: 0px;
  overflow-x: hidden;
  background-color:  #F5F5F5;
  ';
  if (isset($_SESSION["name"])) {

  } else {
    echo 'overflow: hidden; overflow-y: hidden;overflow-x:hidden;';
  }
echo '}

</style>
<script>
  $(document).ready(function() {
      $("#menu").load("menu.php");
    });
</script>
</head>
<body>
<span id="menu"></span>
<div id="wrapper" style="background-color: #339fff; vertical-align: middle;">
  <center>
  <span style="font-size:35px;">
    ' . $slogan . '
  </span>
  <br />
  ' . $sloganSubTxt . '
  </center>
</div>
</body>
</html>'; ?>
