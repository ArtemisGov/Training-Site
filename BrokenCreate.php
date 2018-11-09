<?php
  session_start();
  $mysqli = new mysqli("localhost", "root", "", "RS");
  if (mysqli_connect_errno()) {
    print("Connect failed: %s\n" . mysqli_connect_error());
    exit();
  }
  if (isset($_GET['type'])) {
    $cType = $_GET['type'];
  }
  if (isset($_GET['create'])) {
    $create = $_GET['create'];
  }

  // Make a way to prevent the mass creation of courses opening ?create=yes multiple times.
  // Either use one time id, that's required to make page (that matches one in db)
  // Or create a time limit
  $namaye = $_SESSION["name"];
  $usrid = $_SESSION["usrid"];
  if (isset($create) AND $create == "yes") {
    $sql = "INSERT INTO course (description, creator) VALUES ('1', '" . $usrid . "');";
    mysqli_query($mysqli,$sql);
    $userQuery = "SELECT id, name FROM course WHERE creator = '" . $usrid . "' ORDER BY id DESC LIMIT 1;";
    $userResponse = @mysqli_query($mysqli,$userQuery);
    $userRow = @mysqli_fetch_array($userResponse);
    $_SESSION["course"] = $userRow['id'];
    $sub = "INSERT INTO userCourses (user, course) VALUES ('" . $usrid . "', '" . $userRow['id'] . "');";
    mysqli_query($mysqli,$sub);
    $crazyQuery = "SELECT id FROM course WHERE creator = '" . $usrid . "' AND id='" . $_SESSION["course"] . "' ORDER BY id DESC LIMIT 1;";
    $cResponse = @mysqli_query($mysqli,$crazyQuery);
    $cRow = @mysqli_fetch_array($cResponse);
    $tempID = $cRow['id'];
    $category = "INSERT INTO category ( course ) VALUES ('" . $tempID . "');";
    mysqli_query($mysqli,$category);
    $defaultCatQ = "SELECT id FROM category WHERE course = '" . $tempID . "' ORDER BY id DESC LIMIT 1;";
    $defaultCatRes = @mysqli_query($mysqli,$defaultCatQ);
    $defaultCatRow = @mysqli_fetch_array($defaultCatRes);
    $defaultCatID = $defaultCatRow['id'];
    $_SESSION["category"] = $defaultCatID;
  }
  $latest = $_SESSION["course"];
  // unset latest if the user leaves the page
  $namaye = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($namaye))))));

  if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $type = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($type))))));
    if ($type == "art" OR $type == "code" OR $type == "writing") {
      $updateType = "UPDATE course SET type = '" . $type . "' WHERE creator='" . $usrid . "' AND id='" . $latest . "';";
      mysqli_query($mysqli,$updateType);
    }
  }

  $userQuery = "SELECT name, type FROM course WHERE creator = '" . $usrid . "' AND id='" . $latest . "' ORDER BY id DESC LIMIT 1;";
  $userResponse = @mysqli_query($mysqli,$userQuery);
  $Row = @mysqli_fetch_array($userResponse);
  $finalType = $Row['type'];
  $finalName = $Row['name'];
  // showing strange results. recheck? See $latest note
  // Also issues with updating...
$defaultCatID = $_SESSION["course"];

if(isset($_POST['submit'])) {
  $courseName = $_POST['title'];
  $courseName = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($courseName))))));
  $updateName = "UPDATE course SET name = '" . $courseName . "' WHERE creator='" . $usrid . "' AND id='" . $latest . "';";
  mysqli_query($mysqli,$updateName);
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
?>
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
      /></script>
<script>
  $(document).ready(function() {
      $("#menu").load("menu.php");
  });

  $(function() {
    $('.textarea').on('keyup paste', function() {
      var $el = $(this),
          offset = $el.innerHeight() - $el.height();
      if ($el.innerHeight < this.scrollHeight) {
        //Grow the field if scroll height is smaller
        $el.height(this.scrollHeight - offset);
      } else {
        //Shrink the field and then re-set it to the scroll height in case it needs to shrink
        $el.height(1);
        $el.height(this.scrollHeight - offset);
      }
    });
  });

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
  background-color: <?php if ($finalType == "code") { echo '#339fff;'; } elseif ($finalType == "art") { echo '#c477ee;'; } elseif ($finalType == "writing") { echo '#929292;'; } else { echo '#339fff;'; } ?>
  height: 25vw;
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
    background-color: transparent !important;
    border-color: #34a844;
  }
  .button:hover {
    border-color: #2e913c;
  }
  .checkbox:hover {
    color: #2e913c;
  }
</style>
<title>
  Local Courses
</title>
</head>
<body>
<span id="menu"></span>
<div id="wrapper">
  <noscript>
    This page wont work with Javascript off.
  </noscript>
    <span id="question">
      <dl>
        <dd>
          <center>
            &nbsp;<button id="bigType"> <?php if ($finalType == "code") { echo '<i class="fas fa-code" id="picker" style="font-size: 100px;"></i>'; } elseif ($finalType == "art") { echo '<i class="fas fa-paint-brush" id="picker" style="font-size: 100px;"></i>'; } elseif ($finalType == "writing") { echo '<i class="fas fa-pencil-alt" id="picker" style="font-size: 100px;"></i>'; } else { echo '<i class="fas fa-code" id="picker" style="font-size: 100px;"></i>'; } ?></button>
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
      <form method="post" id="post">
        <input type="text" autocomplete="off" class="courseName" id="cName" name="title" value="<?php if (isset($finalName)) { echo $finalName; } else {  } ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Course Name'"  placeholder="Course Name" />
        <input type="submit" value="Submit" name="submit" style="left: -9999999px;height 2px; position:absolute;">
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
  </div>
  <div class="col-8">
    <div class="card mainCard">
      <div class="card-body">
        <h4 class="card-title">
          <span class="hax">
            <!-- when you click enter for, say course name, one of the other buttons is being executed -->
            <!-- <form method="post">
                <input type="text" class="defaultCatName" name="defaultCatName" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Category Name'"  placeholder="Category Name">
                <button type="submit" class="btn button btn-primary"><i class="far fa-check-circle checkbox"></i></button>
            </form> -->
          </span> <button type="button" title="Submit?" data-content="wooooot" class="btn btn-primary btn-lg extra">More Details</button><button type="button" class="begin btn btn-primary btn-lg extra">Begin</button></h4>
        <br />
        <p class="card-text">
          <!-- <form method="post">
              <textarea cols="40" rows="3" class="defaultCatDesc textarea" name="defaultCatDesc" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Category Description'"  placeholder="Category Description"></textarea>
              <input type="submit" value="defaultCatDesc" name="defaultCatSubmit" style="left: -9999999px;height 2px; position:absolute;">
          </form>
        --> <?php echo $usrid; echo "|"; echo $latest; echo "|"; echo $courseName; ?>
        </p>
      </div>
    </div>
    <div class="band"> </div>
  </div>
</body>
</html>
