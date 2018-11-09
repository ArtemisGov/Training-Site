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
      $success = "yes";
    } else {
      $success = "Mission Failed";
    }
  }
  if (isset($_SESSION["usrid"])) {
    $usrid = $_SESSION["usrid"];
    $usrid = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($usrid))))));
  }

  if (isset($_GET['type'])) {
    $cType = $_GET['type'];
    $cType = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($cType))))));
  }
  if (isset($_GET['create'])) {
    $create = $_GET['create'];
    $create = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($create))))));
  }
  // Use to reopen an editing session from learn.php
  if (isset($_GET['edit'])) {
    $editID = $_GET['edit'];
    $editID = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($editID))))));
    if(is_numeric($editID)) { } else {
      header("Refresh:0; url=index.php");
    }
    $confirmCreatorQ = "SELECT creator FROM course WHERE id='" . $editID . "' ;";
    $confirmCreatorRes = @mysqli_query($mysqli,$confirmCreatorQ);
    $confirmCreatorRow = @mysqli_fetch_array($confirmCreatorRes);
    $confirmCreator = $confirmCreatorRow['creator'];
    if ($confirmCreator != $usrid) {
      header("Refresh:0; url=index.php");
      // Broken?
    }
    unset($_SESSION["category"]);
    unset($_SESSION["course"]);

    $defaultCatQ = "SELECT min(id) FROM category WHERE course = '" . $editID . "' ;";
    $defaultCatRes = @mysqli_query($mysqli,$defaultCatQ);
    $defaultCatRow = @mysqli_fetch_array($defaultCatRes);
    $defaultCatID = $defaultCatRow['min(id)'];
    $_SESSION["category"] = $defaultCatID;
    $_SESSION["course"] = $editID;
    header("Refresh:0; url=create.php");
  }

  // Make a way to prevent the mass creation of courses opening ?create=yes multiple times.
  // Either use one time id, that's required to make page (that matches one in db)
  // Or create a time limit
  $namaye = $_SESSION["name"];


  if (isset($create) AND $create == "yes") {
    $auth = "INSERT INTO authentication (usrid, type) VALUES ('" . $usrid . "', 'group');";
    mysqli_query($mysqli,$auth);
    $authCountQuery = "SELECT COUNT(id), MAX(id) FROM authentication WHERE usrid='" . $usrid . "' AND type='group' AND timestamps >= DATE_SUB(NOW(),INTERVAL 1 HOUR);";
    $authCountRes = @mysqli_query($mysqli,$authCountQuery);
    $authCountRow = @mysqli_fetch_array($authCountRes);
    $authCount = $authCountRow['COUNT(id)'];
    $authID = $authCountRow['MAX(id)'];

    if ($authCount < 3) {
      $sql = "INSERT INTO course (description, creator) VALUES ('1', '" . $usrid . "');";
      mysqli_query($mysqli,$sql);
      $userQuery = "SELECT id, name FROM course WHERE creator = '" . $usrid . "' ORDER BY id DESC LIMIT 1;";
      $userResponse = @mysqli_query($mysqli,$userQuery);
      $userRow = @mysqli_fetch_array($userResponse);
      $_SESSION["course"] = $userRow['id'];
      $tempID = $userRow['id'];
      $sub = "INSERT INTO userCourses (user, course) VALUES ('" . $usrid . "', '" . $userRow['id'] . "');";
      mysqli_query($mysqli,$sub);
      $category = "INSERT INTO category ( course, creator, catnum ) VALUES ('" . $tempID . "', '" . $usrid . "', '1');";
      mysqli_query($mysqli,$category);
      $defaultCatQ = "SELECT id FROM category WHERE course = '" . $tempID . "' ORDER BY id DESC LIMIT 1;";
      $defaultCatRes = @mysqli_query($mysqli,$defaultCatQ);
      $defaultCatRow = @mysqli_fetch_array($defaultCatRes);
      $defaultCatID = $defaultCatRow['id'];
      $_SESSION["category"] = $defaultCatID;
      $autEdit = "UPDATE authentication SET gID = '" . $tempID . "' WHERE id = '" . $authID . "';";
      mysqli_query($mysqli,$autEdit);
  } else {
    $kickout = "yes";
  }
}
  $latest = $_SESSION["course"];
  $namaye = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($namaye))))));

  if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $type = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($type))))));
    if ($type == "art" OR $type == "code" OR $type == "writing") {
      $updateType = "UPDATE course SET type = '" . $type . "' WHERE creator='" . $usrid . "' AND id='" . $latest . "';";
      mysqli_query($mysqli,$updateType);
    }
  }
  if(isset($_POST['submit'])) {
    $courseName = $_POST['title'];
    $courseName = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($courseName))))));
    $updateName = "UPDATE course SET name = '" . $courseName . "' WHERE creator='" . $usrid . "' AND id='" . $latest . "';";
    mysqli_query($mysqli,$updateName);
  }
  if(isset($_POST['categoryButton'])) {
    $defaultCatName = $_POST['defaultCatName'];
    $catNameID = $_POST['catNameID'];
    if (is_numeric($catNameID)) {
      $catNameID = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($catNameID))))));
      $defaultCatName = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($defaultCatName))))));
      $updateCatName = "UPDATE category SET name = '" . $defaultCatName . "' WHERE course='" . $latest . "' AND creator='" . $usrid . "' AND id='" . $catNameID . "';";
      mysqli_query($mysqli,$updateCatName);
    }
  }
  if(isset($_POST['defaultCatSubmit'])) {
    $defaultCatDesc = $_POST['defaultCatDesc'];
    $catDescID = $_POST['catDescID'];
    if (is_numeric($catDescID)) {
      $catDescID = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($catDescID))))));
      $defaultCatDesc = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($defaultCatDesc))))));
      $updateCatDesc = "UPDATE category SET description = '" . $defaultCatDesc . "' WHERE course='" . $latest . "' AND creator='" . $usrid . "' AND id='" . $catDescID . "';";
      mysqli_query($mysqli,$updateCatDesc);
    }
  }

  $userQuery = "SELECT id, name, type FROM course WHERE creator = '" . $usrid . "' AND id='" . $latest . "' ORDER BY id DESC LIMIT 1;";
  $userResponse = @mysqli_query($mysqli,$userQuery);
  $Row = @mysqli_fetch_array($userResponse);
  $finalType = $Row['type'];
  $finalID = $Row['id'];
  $finalName = $Row['name'];

  $connection = @mysqli_connect("localhost","root","","RS");
  $defCatNameQuery = "SELECT id, name, description FROM category WHERE course='" . $latest . "' AND creator='" . $usrid . "';";
  $res=$connection->query($defCatNameQuery);

  $defCatNameQuery2 = "SELECT COUNT(id), MIN(id), name, description FROM category WHERE course='" . $latest . "' AND creator='" . $usrid . "';";
  $defCatNameResponse = @mysqli_query($mysqli,$defCatNameQuery2);
  $defCatNameRow = @mysqli_fetch_array($defCatNameResponse);
  $categoryCount = $defCatNameRow['COUNT(id)'];
  $categoryMIN = $defCatNameRow['MIN(id)'];
  // not working thanks to where $_SESSION["category"]

  if(isset($_POST['addCat'])) {
    $categoryCount = $categoryCount + 1;
    $category = "INSERT INTO category ( course, creator, catnum ) VALUES ('" . $finalID . "', '" . $usrid . "', '" . $categoryCount . "');";
    mysqli_query($mysqli,$category);
    header("Refresh:0;");
  }
?>
<!DOCTYPE html>
<html>
<head>
<?php
if (isset($create) AND $create == "yes") {
  echo "<meta http-equiv='refresh' content='0; url=create.php' />";
}
if (isset($type)) {
  echo "<meta http-equiv='refresh' content='0; url=create.php' />";
}
if (isset($kickout)) {
  echo "<meta http-equiv='refresh' content='0; url=index.php' />";
}
if (isset($success) == "yes") {
echo '<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
      <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<script>
  $(document).ready(function() {
      $("#menu").load("menu.php");
  });


//copypasta https://stackoverflow.com/questions/12622019/preventing-firefox-reload-confirmation
//    var processConfirmation = confirm("You\'ve Edited "+ noEditedRecords +" Records. Are You sure to undo the Changes made?");

//    if (processConfirmation ==true){

//            window.onbeforeunload = null;

//            window.location=window.location;}

//}}
var autosaveOn = false;
$("#cName").on("input", function() {
    var autosaveOn = true;
    myAutosavedTextbox_onTextChanged();
});
function myAutosavedTextbox_onTextChanged()
{
    if (!autosaveOn)
    {
        autosaveOn = true;

        $("#cName").everyTime("300000", function(){
             $.ajax({
                 type: "POST",
                 url: "creato.php",
                 success: function(msg) {
                     $("#saved").text(msg);
                 }
             });
        }); //closing tag
    }
}
</script>
<style>
html, body {
  margin: 0px;
  overflow-x: hidden;
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
  border: none;
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
  margin-left: 10px;
}
#wrapper {
  position: relative;
  margin-top: 50px;
  background-color:';  if ($finalType == "code") { echo '#339fff;'; } elseif ($finalType == "art") { echo '#c477ee;'; } elseif ($finalType == "writing") { echo '#929292;'; } else { echo '#339fff;'; }

  echo 'height: 25vw;
  width: 100vw;
  color: white;
  padding: 10px;
}
#question {
  position: relative;
  width: 100%;
  font-size: 100px;
}
#name {
  position: absolute;
  bottom: 0;
  font-size: 30px;
  text-align: center;
  width: 100%;
}
h4 {
  width: 100%;
  text-align: right;
}
.hax {
  position: absolute;
  left:20px;
  text-align: left !important;
}
button {
  padding: 10px !important;
  border-radius: 2px !important;
  font-size: 17px !important;
}
.begin {
  margin-left: 10px;
}
.count {
  border: 5px solid;
  font-size: 22px;
  border-color: #8c9399;
  border-radius: 50px;
  width: 50px;
  height: 50px;
  left: 50%;
}
.mainCard {
  border-bottom-left-radius: 0px;
  border-bottom-right-radius: 0px;
  border-bottom: 0px;
}
.band {
  width:100%;
  height:6px;
  background-color: rgb(51, 159, 255);
  border-bottom-right-radius: 2px;
  border-bottom-left-radius: 2px;
}
.courseName {
  background-color: transparent;
  border: 0px;
  text-align: center;
  width: 50%;
  color: white;
}
 .courseName::placeholder {
   color: #e0e4e7;
 }
 dl {
    list-style-type: none;
 }
 .type-pick {
   transition: visibility .1s ease-in-out .001s;
   position: fixed;
   background-color: white;
   text-align: center;
   visibility: hidden;
   font-size: 20px;
   padding: 20px;
   left: 44.8vw;
   border-radius: 1px;
   transition: visibility .1s ease-in-out .001s;
 }
 #bigType:focus + .type-pick {
   transition: visibility .1s ease-in-out .001s;
   visibility: visible;
   transition: visibility .1s ease-in-out .001s;
 }
 #bigType {
   border: 0px;
   vertical-align: bottom;
   background-color: transparent;
   color: white;
 }
 .art {
   color: #c477ee;
 }
 .art:hover {
   color: #9c60bc;
 }
 .code {
   color: #5ebd5f;
   font-size: 30px;
 }
 .code:hover {
   color: #4f9d51;
 }
 .fa-paint-brush {
   font-size: 30px;
 }
 .margin {
   margin: 5px;
 }
 .writing {
   color: #929292;
   font-size: 30px;
 }
 .writing:hover {
   color: #4a494b;
 }
 .defaultCatName {
   border: 0px;
   color: #4a494b;
   background-color: transparent;
 }
 .defaultCatName::placeholder {
   color: #5d5b5e;
 }
 input:focus {
    outline-width: 0;
  }
  .defaultCatDesc {
    border: 0px;
    color: #4a494b;
    background-color: transparent;
  }
  textarea {
    border: none;
    overflow: auto;
    outline: none;
    width: 100%;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
    resize: none;
  }
  .checkbox {
    color: #34a844;
  }
  .button {
    background-color: transparent;
    border-color: #34a844;
    width: 100%;
  }
  .button:hover {
    border-color: #88e495;
    background-color: #88e495;
  }
  .checkbox:hover {
    color: #2e913c;
  }
  #status {
    width: 100vw;
    background-color: white;
    height: 75px;
    position: fixed;
    bottom: 0px;
    padding: 20px;
    padding-top: 5px;
    z-index: 20;
  }
  #statusContent {
    margin:2px;
    text-align: right;
  }
  .up {
    bottom: 100% !important;
    top: auto !important;
    float: right !important;
  }
  .dropdown {
    float: right !important;
  }
  .btn-status {
    width: 200px;
  }
  #menu {
    width 100vw;
    height: 50px;
  }
</style>
<title>
  Local Courses
</title>
</head>
<body>
<span id="menu"></span>
<div id="status">
<span id="saved">

</span>
  <span id="statusContent">
  <div class="dropdown">
    <button class="btn btn-secondary btn-lg dropdown-toggle btn-status" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Course Status
    </button>
    <div class="dropdown-menu up" aria-labelledby="dropdownMenuButton" style="width: 200px;">
      <form method="post">
        <button type="submit" name="" class="dropdown-item" href="#"><i class="fas fa-square" style="color: #ce4431;"></i> &nbsp; Unlisted</button>
      </form>
      <form method="post">
        <button class="dropdown-item" href="#"><i class="fas fa-square" style="color: #5d665e;"></i> &nbsp; Private</button>
      </form>
      <form method="post">
        <button class="dropdown-item" href="#"><i class="fas fa-square" style="color: #3174ce;"></i> &nbsp; Published</button>
      </form>
    </div>
  </div>
  </span>
</div>

<div id="wrapper">
  <noscript>
    This page wont work with Javascript off.
  </noscript>
    <span id="question">
      <dl>
        <dd>
          <center>
            &nbsp;<button id="bigType">'; if ($finalType == "code") { echo '<i class="fas fa-code" id="picker" style="font-size: 100px;"></i>'; } elseif ($finalType == "art") { echo '<i class="fas fa-paint-brush" id="picker" style="font-size: 100px;"></i>'; } elseif ($finalType == "writing") { echo '<i class="fas fa-pencil-alt" id="picker" style="font-size: 100px;"></i>'; } else { echo '<i class="fas fa-code" id="picker" style="font-size: 100px;"></i>'; } echo '</button>
            <div class="type-pick">
              <a href="create.php?type=art" class="art margin"><i class="fas fa-paint-brush"></i></a>
              <a href="create.php?type=writing"><i class="fas writing fa-pencil-alt"></i></a>
              <a href="create.php?type=code"><i class="fas code fa-code"></i></a>
            </div>
          </center>
        </dd>
      </dl>
    </span>
    <span id="name">
      <form method="post" id="cPost">
        <input type="text" autocomplete="off" class="courseName" id="cName" name="title" value="'; if (isset($finalName)) { echo $finalName; } else {  } echo '" onfocus="this.placeholder = \'\'" onblur="this.placeholder = \'Course Name\'"  placeholder="Course Name" />
        <input type="submit" value="Submit" name="submit" id="cSubmit" style="left: -9999999px;height 2px; position:absolute;">
      </form>
      <br />
    </span>
</div>
<br />
<div class="row">
  <div class="col-2">
    <center>
        <div class="count">
          1
        </div>
    </center>
  </div><div class="col-8">';
  while($rows=$res->fetch_assoc()){
    $defCatName = $rows['name'];
    $defCatDesc = $rows['description'];
    $defCatID = $rows['id'];

  echo '<div class="card mainCard">
      <div class="card-body">
        <h4 class="card-title">
          <span class="hax">
            <!-- when you click enter for, say course name, one of the other buttons is being executed -->
             <form method="post">
                <input type="text" class="defaultCatName" name="defaultCatName" onfocus="this.placeholder = \'\'" onblur="this.placeholder = \'Category Name\'"  value="'; if (isset($defCatName)) { echo $defCatName; } else {  }  echo '" placeholder="Category Name">
                <input type="text" class="defaultCatName uneditable-input" name="catNameID" value="' . $defCatID . '" style="position:absolute; left: -9999999px; height: 3px;" readonly>
                <button type="submit" name="categoryButton" style="position:absolute; left: -9999999px; height: 3px;" class="btn button btn-primary"><i class="far fa-check-circle checkbox"></i></button>
            </form>
          </span> <button type="button" title="Submit?" data-content="wooooot" class="btn btn-primary btn-lg extra">More Details</button><button type="button" class="begin btn btn-primary btn-lg extra">Begin</button></h4>
        <br />
        <p class="card-text">
           <form method="post">
              <textarea cols="40" rows="3" class="defaultCatDesc textarea" name="defaultCatDesc" onfocus="this.placeholder = \'\'" onblur="this.placeholder = \'Category Description\'"  placeholder="Category Description">'; if (isset($defCatDesc)) { echo $defCatDesc; } else {  } echo '</textarea>
              <input type="text" class="defaultCatName uneditable-input" name="catDescID" value="' . $defCatID . '" style="position:absolute; left: -9999999px; height: 3px;" readonly>
              <button type="submit" value="defaultCatDesc" name="defaultCatSubmit" class="btn btn-primary button btn-lg extra"><i class="far fa-check-circle checkbox"></i></button>
          </form>';
         echo $usrid; echo "|"; echo $latest; echo "|"; echo $courseName; echo "|"; echo $_SESSION["category"];
        echo '</p>
      </div>
    </div>
    <div class="band"> </div><br />';
    }

    echo '<center>
      <form method="post">
          <button type="submit" name="addCat" class="btn btn-primary btn-lg extra">Add Category</button>
      </form>
   </center>
   <br />
   </div>
  </div>
</body>
</html>';
} else {
  header("Refresh:0; url=login.php");
}
?>
