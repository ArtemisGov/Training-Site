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
  // Include in other pages, block access if not logged in
  // Truncate the authentication table daily.
echo '<!DOCTYPE html>
<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
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
}
#wrapper {
  display: flex;
  width: 100vw;
  height: 100vh;
  flex-direction: column;
  justify-content: center;
  overflow: auto;
}
form {
  width: 80%;
}
h2 {
  font-family: "Lato", sans-serif;
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
#menuAvatar {
  height: 28px;
  width: 28px;
}
#rando {
  text-align: center;
  padding: 17px 10px;
  text-decoration: none;
  font-size: 19px;
  border:none;
  background-color: white;
}
#rando:focus + .dropdown-content {
  visibility: visible;
  transition: visibility .1s ease-in-out .01s;
}
.dropdown-content:focus + .dropdown-content {
  visibility: visible;
  transition: visibility .1s ease-in-out .01s;
}

</style>
<script>
  $(document).ready(function() {
      $("#menu").load("menu.php");
    });
</script>
</head>
<body>
<span id="menu"></span>

</body>
</html>'; ?>
