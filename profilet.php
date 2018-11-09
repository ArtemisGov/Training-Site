<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <?php
  $userid = $_GET['user'];
  $userid = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($userid))))));

  $mysqli = new mysqli("localhost", "root", "", "RS");

  if (mysqli_connect_errno()) {
    print("Connect failed: %s\n" . mysqli_connect_error());
    exit();
  }
  $userQuery = "SELECT usrid, username, oldname, languages, joindate, art, hunting, frontwebdev, backwebdev, writing, programming, se, smm, pentesting, timezone, availability, reliability, profilePicture, wallpaper FROM userinfo WHERE usrid='" . $userid . "';";
  $userResponse = @mysqli_query($mysqli,$userQuery);
  $userRow = @mysqli_fetch_array($userResponse);

  $hunter = $userRow['hunting'];
  $art = $userRow['art'];
  $webdev = $userRow['frontwebdev'];
  $programming = $userRow['programming'];
  $se = $userRow['se'];
  $writing = $userRow['writing'];
  $smm = $userRow['smm'];
  $wallpaper = $userRow['wallpaper'];
  $username = $userRow['username'];
  $oldnames = $userRow['oldname'];
  $availability = $userRow['availability'];
  $reliability = $userRow['reliability'];
  $avatar = $userRow['profilePicture'];


    if(isset($_POST['submit'])) {
      $complete = 1;

      $preachievementname = $_POST['achievementname'];
      $predescr = $_POST['descr'];
      $achievementname = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($preachievementname))))));
      $descr = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($predescr))))));
      $sql = "INSERT INTO achievements (achievementname, achievementdescr, usrid, complete) VALUES ('" . $achievementname . "', '" . $descr ."', '" . $userid . "','". $complete ."');";
      mysqli_query($mysqli,$sql);
      header("Refresh:0");
    }

    if(isset($_POST['submit'])) {
      $wallpaper = $_POST['wallpaper'];
      $wallpaper = var_dump(filter_var($wallpaper, FILTER_SANITIZE_URL));
      # Use getimagesize('url'); to confirm it's on a url once on a real server
      $sql = "UPDATE userinfo SET wallpaper='" . $wallpaper . "' WHERE usrid='" . $userid . "';";
      mysqli_query($mysqli,$sql);
      header("Refresh:0");
    }
  ?>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>
    Profile
  </title>
  <style>
  html,body {
    margin: 0px;
    overflow-x: hidden;
    background-color: #F5F5F5;
  }
  #imageWrap {
    width: 100vw;
    height: 60vh;
    background-color: grey;
  }
  #wallpaper {
    width: 100vw;
    height: 60vh;
  }
  #avatar {
    border-radius: 100px;
    width: 150px;
    height: 150px;
    top: 53vh;
    z-index: 1;
    margin-left: -23%;
    position: absolute;
    background-color: grey;
  }
  #infoBox {
    float: left;
    border: 1px solid #e8e8e8;
    width: 300px;
    display: inline-block;
    margin-left: 4.5vw;
    background-color: white;
    height: 500px;
    text-align: center;
    border-radius: 3px;
  }
  #infoBoxText {
    margin-top: 200px;
  }
  .title {
    font-size: 25px;
    font-weight: bold;
    font-family: 'Open Sans', sans-serif;
  }
  .subtext {
    color: grey;
  }
  .itemStyle {
    padding-left: 20px;
    padding-right: 20px;
    cursor: default;
    padding-top: 10px;
    padding-bottom: 10px;
    display: inline-block;
    background-color: grey;
    color: white;
    opacity: .8;
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
  li a {
    display: block;
    color: black;
    text-align: center;
    padding: 25px 16px;
    text-decoration: none;
    font-size: 19px;
  }
  .navSearch {
    border-width: 0px;
    height: 25px;
    outline: none;
    font-size: 17.5px;
    color: #545454;
    width: 300px;
  }
  .searchWrap {
    border: solid 1px #6A6A6A;
    border-radius: 1px;
    padding: 4px;
    margin-top: 18px;
  }
  .profileTabs {
    margin-top:-25px;
    display: inline-block;
    position: absolute;
    left: 45vw;
    cursor: pointer;
    text-align: center;
    padding-left: 30px;
    padding-right: 30px;
    padding-top: 10px;
    padding-bottom: 10px;
    border-radius: 1px;
    background-color: white;
  }
  .profileTab2 {
    left: 60vw;
  }
  #editIco {
    transition-duration: 2s;
    transition-timing-function: ease;
    opacity: 0;
    transition-duration: 2s;
    transition-timing-function: ease;
  }
  #title:hover + #editIco {
    transition-duration: 2s;
    transition-timing-function: ease;
    opacity: 1 !important;
    transition-duration: 2s;
    transition-timing-function: ease;
  }
  #nopacity {
    opacity: 0;
  }
  #outamyway {
    width: 30px;
    display: inline-block;
    margin-left: 4.5vw;
    height: 100vh;
    float:left;
  }
  .genTitle {
    margin-top:10px;
    font-size:30px;
    text-align:center;
  }
  .switch1 {
    display: visible;
  }
  .switch2 {
    display: none;
  }
  .txtarea {
    width:600px;
    background-color: white;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    border-width: 0px;
    font-size: 17.5px;
    resize: none;
    margin-left: -10%;
    height: 100px;
  }
  .formName {
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
    background-color: white;
    border-width: 0px;
    border-bottom: none;
    padding: 10px;
    margin-left: -10%;
    font-size: 17.5px;
    width:600px;
  }
  .submit {
    width:600px;
    cursor: pointer;
    background-color: white;
    border-width: 0px;
    margin-left: -10%;
    padding: 10px;
  }
  .green {
    background-color: #47A939;
  }
  .lime {
    background-color: #58CD47;
  }
  .lemon {
    background-color: #BDCD47;
  }
  .orange {
    background-color: #CDA047;
  }
  .strawberry {
    background-color: #CD5D47;
  }
  #leftWrapper {
    max-width: 26%;
    float: left;
    overflow: hidden;
  }
  #rightWrapper {
    width: 65%;
    float: right;
    overflow: hidden;
  }
  #recentActivity {
    display: visible;
  }
  #skillInfo {
    display: none;
  }
  #checkboxWrapper {
    width: 600px;
    background-color: white;
    margin-left: -10%;
    padding: 5px;
  }
  #avatarEdit {
    border-radius: 100px;
    width: 150px;
    height: 150px;
    top: 53vh;
    z-index: 2;
    line-height:40px;
    margin-left: -23%;
    color:white;
    position: absolute;
    font-size: 60px;
    text-align: center;
    background-color: grey;
    opacity: .7;
  }
  #savebtn {
    margin-top: 18px;
    margin-right: 30px;
  }
  #wallpaperEdit {
    width: 100vw;
    height: 60vh;
    top:0px;
    position: absolute;
    background-color: grey;
    opacity: .7;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    overflow: auto;
    font-size: 60px;
    text-align: center;
  }
  .forceDisplay {
    display: none !important;
  }
  .switch3 {
    display: unset;
  }
  .switch4 {
    display: none;
  }
  .switch5 {
    display: unset;
  }
  .switch6 {
    display: none;
  }
  .wallpaperEditT {
    display:none;
  }
  </style>
  <script>
  function current() {
    $(".switchOne").addClass("switch2");
    $(".switchTwo").removeClass("switch2");
    $(".switchTwo").addClass("switch1");
  }
  function complete() {
    $(".switch2").addClass("switchOne");
    $(".switch2").removeClass("switch2");
    $(".switchTwo").addClass("switch2");
  }
  function skillInfo() {
    $("#skillInfo").removeClass("switch2");
    $("#recentActivity").addClass("switch2");
    $("#skillInfo").addClass("switch1");
  }
  function profileTabs() {
    $("#recentActivity").addClass("switch1");
    $("#recentActivity").removeClass("switch2");
    $("#skillInfo").addClass("switch2");
  }
  function titleClick() {
    $(".switch6").addClass("switch5");
    $(".switch6").removeClass("switch6");
  }
  function editProfile() {
    $(".switch4").addClass("switch3");
    $(".forceDisplay").addClass("forceDisplayPlaceholder");
    $(".switch4").removeClass("forceDisplay");
    $(".switch4").removeClass("switch4");
  }
  function saveChanges() {
    $(".forceDisplayPlaceholder").addClass("forceDisplay");
    $(".switch3").addClass("switch4");
    $(".switch4").removeClass("switch3");
    $(".switch5").addClass("switch6");
    $(".switch5").removeClass("switch5");
  }
  function toggleBackgroundFormOn() {
    $("#wp").removeClass("wallpaperEditT");
  }
  </script>
</head>
<body>
  <ul>
    <li id="savebtn" class="profileEdit switch4"><button type="button" class="btn btn-primary" onclick="saveChanges()">Save</button></li>
    <li style="float:left !important; margin-left:20px;">
      <div class="searchWrap">
        <form action="search.php">
          <i class="fas fa-search" style="color: #6A6A6A;"></i>
          <input class="navSearch" type="text" name="search" id="bug"/>
          <input type="submit" id="rat" style="position: absolute; left: -9999px"/>
        </form>
      </div>
    </li>
    <li><a href="" style="margin-right: 30px;">Contact</a></li>
    <li><a href="">Jobs</a></li>
    <li><a href="">Courses</a></li>
    <li><a href="" style="">About</a></li>
    <li><a href="index.php">Home</a></li>
</ul>
<div id="imageWallpaperWrap">
  <?php
  $connection = @mysqli_connect("localhost","root","","RS");
  if($connection->connect_error){//show error if connection failed
      die("Connection failed: " . $connection->connect_error);
  }

  if ($wallpaper != 0 or $wallpaper != NULL) {
    echo "<img src='" . $wallpaper . "' alt='background' id='wallpaper' onclick='toggleBackgroundFormOn()' /><div id='wallpaperEdit' class='profileEdit switch4 forceDisplay'><i class='fas fa-upload'></i>
    <span class='wallpaperEditT' id='wp'>
      <form action='profilet.php'>
        <input class='navSearch' type='text' class='form-control' name='wallpaper' id='bug'/>
        <input type='submit' class='btn btn-primary' id='rat' style='position: absolute;'/>
      </form>
    </span>
  </div>";
  } else {
    echo "<img src='user1.jpg' alt='background' id='wallpaper' /><div id='wallpaperEdit' onclick='toggleBackgroundFormOn()' class='profileEdit switch4 forceDisplay'><i class='fas fa-upload'></i></div>
    <span class='wallpaperEditT'>
      <form action='profilet.php'>
        <input class='navSearch' type='text' class='form-control' name='wallpaper' id='bug'/>
        <input type='submit' class='btn btn-primary' id='rat' style='position: absolute;'/>
      </form>
    </span>
  </div>";
  }


  if ($avatar != 0 or $avatar != NULL) {
    echo "<img src=" . $avatar . " alt='avatar' id='avatar' /><div id='avatarEdit' class='profileEdit switch4'><br /><i class='fas fa-upload'></i></div>";
  } else {
    echo "<img src='logopic.png' alt='avatar' id='avatar' /><div id='avatarEdit' class='profileEdit switch4'><br /><i class='fas fa-upload'></i></div>";
  }
  ?>
<!-- php echo "<img id='wallpaper' src='" .  . "'/>" -->
</div>

<div id="leftWrapper">
<div id="infoBox">
    <br /><br /><br /><br /><br />
  <span class="title" id="title" onclick="titleClick()">
      <?php echo $username; ?>
  </span>
  <span onclick="editProfile()" class="switch6" id="editbtn">
    <i class="fas fa-edit"></i>
  </span>
  <br>
  <span class="subtext">
    <?php echo $oldnames; ?>
  </span>
  <br /><br />
  <?php
  if ($availability >= 4) {
    echo '<div class="itemStyle green" title="Availability"> Very Active</div>';
  } elseif ($availability > 3 && $availability <= 4) {
      echo '<div class="itemStyle lime" title="Availability"> Active</div>';
    } elseif ($availability > 2 && $availability <= 3)  {
      echo '<div class="itemStyle lemon" title="Availability"> Avg. Activity</div>';
    } elseif ($availability > 1 && $availability <= 2)  {
      echo '<div class="itemStyle orange" title="Availability"> Slow</div>';
    } elseif ($availability > 0 && $availability <= 1)  {
      echo '<div class="itemStyle strawberry" title="Availability"> Inactive</div>';
    }
    ?>


  <?php
  if ($reliability >= 4) {
    echo '<div class="itemStyle green" title="Reliability"> Very Reliable</div>';
  } elseif ($reliability > 3 && $reliability <= 4) {
    echo '<div class="itemStyle lime" title="Reliability"> Reliable</div>';
  } elseif ($reliability > 2 && $reliability <= 3)  {
    echo '<div class="itemStyle lemon" title="Reliability"> Avg. Reliablility</div>';
  } elseif ($reliability > 1 && $reliability <= 2)  {
    echo '<div class="itemStyle orange" title="Reliability"> Low Reliability</div>';
  } elseif ($reliability > 0 && $reliability <= 1)  {
    echo '<div class="itemStyle strawberry" title="Reliability"> Not Reliable</div>';
  }
  ?>

  <!-- Use Moment Timezone for time of user now https://www.timeanddate.com/clocks/free.html -->
  <div id="clock">

  </div>
</div>
</div>
<div id="outamyway"></div>
<center> <!-- Use different background color for which is active -->
  <div class="profileTabs" onclick="profileTabs()">
    Recent Activity
  </div>
  <div class="profileTabs profileTab2" onclick="skillInfo()">
    Skill Information
  </div>
</center>
<div id="rightWrapper">
<span id="recentActivity">
<!--php echo "<img id='logo' src='" .  . "'>" -->
<br /><br />
<center>
<form method="post" id="post">
  <input type="text" class="form-control formName" name="achievementname" placeholder="Name">
  <textarea class="form-control txtarea" type="text" name="descr" id="textarea" placeholder="Description"></textarea>
  <div id="checkboxWrapper"> Mark as complete <input id="checkBox" type="checkbox" name="checkBox"></div>
  <input type="submit" name="submit" value="Submit" class="submit" id="submit"/>
</form>
</center>
<br /><br /><center>
<ul style="width: 95%; top: unset !important; position: static; padding: 20px; float: unset;">
  <li onclick="complete()" style="cursor: pointer; float:unset; display:inline-block;margin-right:20px;margin-left:-10px;">
    Complete
  </li>
  <li onclick="current()" style="cursor: pointer; float:unset; display:inline-block;margin-left:20px;">
    Current
  </li>
</center>
</ul>
<?php
  $query = "SELECT achieveid, achievementname, achievementdescr, date(timestamps), complete FROM achievements WHERE usrid=" . $userid . " AND complete=TRUE AND timestamps >= now()-interval 3 month ORDER BY timestamps DESC;";
  $response = @mysqli_query($mysqli,$query);

  $activeTasks = "SELECT achieveid, achievementname, achievementdescr, date(timestamps), complete FROM achievements WHERE usrid=" . $userid . " AND complete=FALSE";
  $activeTasksResponse = @mysqli_query($mysqli,$activeTasks);

  if($response){
    while($row = mysqli_fetch_array($response)){
      echo '
      <div class="card-group switch1 switchOne" style="width:200px; float: left; margin-left: 20px; margin-top:80px;">
      <div class="card" style="padding:10px;">
      <div class="card-block">
      <h4 class="card-title">'
       . $row['achievementname'] . '
       </h4>
       <span class="timestamp">'
      . $row['achievementdescr'] .
      '</span>
      </div>
      <div class="card-footer">
      <p class="card-text">
      <small class="text-muted">'
      . $row['date(timestamps)'] .
      '</small>
      </p>
      </div>
      </div>
      </div>';
    }
  } else {
    echo "Couldn't issue database query<br />";
    echo mysqli_error($response);
  }


  if($activeTasksResponse){
    while($acRow = mysqli_fetch_array($activeTasksResponse)){
      echo '
      <div class="card-group switchTwo switch2" style="width:200px; float: left; margin-left: 20px; margin-top:80px;">
      <div class="card" style="padding:10px;">
      <div class="card-block">
      <h4 class="card-title">'
       . $acRow['achievementname'] . '
       </h4>
       <span class="timestamp">'
      . $acRow['achievementdescr'] .
      '</span>
      </div>
      <div class="card-footer">
      <p class="card-text">
      <small class="text-muted">'
      . $acRow['date(timestamps)'] .
      '</small>
      </p>
      </div>
      </div>
      </div>';
    }
  } else {
    echo "Couldn't issue database query<br />";
    echo mysqli_error($activeTasksResponse);
  }


  $mysqli->close();
 ?>
</span>
<span id="skillInfo" class="switch2">
  test
</span>
</div>
</body>
</html>
