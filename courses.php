<?php
  session_start();

  $connection = @mysqli_connect("localhost","root","","RS");
  $usrid = $_SESSION["usrid"];
  $Query = "SELECT name, description, creator, type  FROM course WHERE NOT creator='" . $usrid . "' AND status = 3;";
  $res=$connection->query($Query);

  if (isset($_SESSION["name"])) {
    $nome = $_SESSION["name"];
    $un_pass = $_SESSION["session"];
    $userQuery = "SELECT realUsername, sessionID FROM authentication WHERE realUsername='" . $nome . "' ORDER BY id DESC LIMIT 1;";
    $userResponse = @mysqli_query($mysqli,$userQuery);
    $userRow = @mysqli_fetch_array($userResponse);
    $hash = $userRow['sessionID'];
    if(password_verify($un_pass, $hash)) {
      $success = "yes";
    } else {
      $success = "Mission Failed";
    }
  }
if (isset($success) == "yes") {
echo '
<!DOCTYPE html>
<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
      $("#menu").load("menu.php");
  });
</script>
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
#addCourse {
  margin-left: 65%;
}
#courses {
  font-family: "Roboto", sans-serif;
  font-weight: 300;
  font-size: 20px;
  margin-left:10px;
}
#wrapper {
  margin-top: 120px;
}
button.extra {
  transition: width .1s ease-in-out 600000s;
  width: 50px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
button.extra:hover {
  transition-delay:0s;
  transition: width .1s ease-in-out .01;
  width: 250px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
</style>
<title>
  Courses
</title>
</head>
<body>
<span id="menu"></span>
<div id="wrapper">
  <span id="courses">
    Add Courses
  </span>
   <span id="addCourse">
      <a href="create.php?create=yes">
        <button type="button" class="btn btn-primary btn-lg extra">
          <i class="fas fa-plus"></i>
          <span id="fill">
            &nbsp;&nbsp;&nbsp;
          </span>
          Create a Course
        </button>
      </a>
    </span>
    <hr />

    ';
    while($row=$res->fetch_assoc()){
    $name = $row['name'];
    $description = $row['description'];
    $type = $row['type'];
    $creator = $row['creator'];
    echo '
        <div class="card" style="width: 18rem;display:inline-block;margin-top:10px;margin-left:10px;">
          <img class="card-img-top" src="';
          if ($type == "code" or $type == NULL) {
            echo 'code.png';
          } elseif ($type == "art") {
            echo 'art.png';
          } elseif ($type == "writing") {
            echo 'writing.png';
          }
          echo '" alt="Coding Img" height="200">
          <div class="card-body">
            <h5 class="card-title">' . $name . '</h5>
            <p class="card-text">' . $description . '</p>
            <br />
          </div>
        </div>
    ';
    }
    echo '

</body>
</html>';
} else {
  header("Refresh:0; url=login.php");
}
?>
