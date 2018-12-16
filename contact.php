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
  if(isset($_POST['cForm'])) {
    $email = "admin@artemisrepublic.co";
    $subject = "Training Site Contact Form Inquiry From: ";
    $name = $_POST['name'];
    $source = $_POST['email'];
    $subject = $subject.$name;
    $message = $_POST['message'];
    $headers = 'From: ' . $source . "\r\n" .
    'Reply-To: info@artemisrepublic.co' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($email, $subject, $message, $headers);
    // remember to add additional security incl. filtering.
  }

  // Use this for view control
  // Include in other pages, block access if not logged in
  // Truncate the authentication table daily.
echo '<!DOCTYPE html>
<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link href="./css/contact.css" rel="stylesheet">
<script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
  <title>
    Home
  </title>
<script>
  $(document).ready(function() {
      $("#menu").load("menu.php");
    });
</script>
</head>
<body>
<span id="menu"></span>
<br />
<div id="wrapper">
  <h4>
    Contact us
  </h4>
  <br />
  <form method="post">
    <div class="form-group">
      <label for="formGroupExampleInput">Name or Username</label>
      <input type="text" class="form-control" id="formGroupExampleInput" name="name" placeholder="John Doe / Skr1ptk1d9000">
    </div>
    <div class="form-group">
      <label for="exampleFormControlInput1">Email address</label>
      <input type="email" class="form-control" id="exampleFormControlInput1" name="email" placeholder="name@example.com">
    </div>
    <div class="form-group">
      <label for="exampleFormControlTextarea1">Message</label>
      <textarea class="form-control" id="exampleFormControlTextarea1" name="message" rows="3"></textarea>
    </div>
    <input type="submit" title="Submit?" name="cForm" class="btn btn-primary btn-lg extra" value="Submit">
  </form>
</div>
</body>
</html>'; ?>
