<!DOCTYPE html>
<html lang="en">
<head>
  <?php $userid = $_GET['user'];?>
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
    top: 55vh;
    margin-left: 10vw;
    position: absolute;
    background-color: grey;
  }
  #infoBox {
    top: 52vh;
    border: 1px solid #e8e8e8;
    width: 300px;
    display: inline-block;
    margin-left: 4.5vw;
    height: 500px;
    text-align: center;
    border-radius: 3px
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
  #availability {
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 10px;
    padding-bottom: 10px;
    display: inline-block;
    color: white;
    opacity: .8;
    background-color: green;
  }
  ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: white;
    position: fixed;
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
  #langs {
    position: absolute;
    bottom: -100px;
  }
  .profileTabs {
    top:62vh;
    display: inline-block;
    position: absolute;
    left: 45vw;
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
  </style>
  <script>
    function editItem() {

    }
  </script>
</head>
<body>
  <ul>
    <li style="float:left !important; margin-left:20px;">
      <div class="searchWrap">
        <form>
          <i class="fas fa-search" style="color: #6A6A6A;"></i>
          <input type="text" class="navSearch" name="FirstName">
        </form>
      </div>
    </li>
    <li><a href="" style="margin-right: 30px;">Contact</a></li>
    <li><a href="">Tasks</a></li>
    <li><a href="" style="">About</a></li>
    <li><a href="">Home</a></li>
</ul>
<div id="imageWallpaperWrap">
  <img src="user1.jpg" alt="background" id='wallpaper' />
<!-- php echo "<img id='wallpaper' src='" .  . "'/>" -->
</div>

<img src="logopic.png" alt="avatar" id='avatar' />
<div id="infoBox">
    <br /><br /><br /><br /><br />
    <span id="nopacity" onclick="editItem();">
      <i class="fas fa-edit"></i>
    </span>
  <span class="title" id="title">
      Name
  </span>
  <span id="editIco">
    <i class="fas fa-edit"></i>
  </span>
  <br>
  <span class="subtext">
    Past names
  </span>
  <br /><br />
  <div id="availability" title="Availability">
    test
  </div>
  <div id="availability" title="Reliability">
    test
  </div>
  <!-- Use Moment Timezone for time of user now https://www.timeanddate.com/clocks/free.html -->
  <div id="clock">

  </div>
  <span id="langs">
    lang icons
  </span>
</div>
<center>
<div class="profileTabs">
  Recent Activity
</div>
<div class="profileTabs profileTab2">
  Skill Information
</div>
</center>

<!--php echo "<img id='logo' src='" .  . "'>" -->
<?php

  $mysqli = new mysqli("localhost", "root", "", "RS");

  if (mysqli_connect_errno()) {
    print("Connect failed: %s\n" . mysqli_connect_error());
    exit();
  }
  $query = "SELECT achieveid, achievementname, achievementdescr, date(timestamps) FROM achievements WHERE usrid=" . $userid . " AND complete=TRUE;";
  $response = @mysqli_query($mysqli,$query);

  if($response){
    while($row = mysqli_fetch_array($response)){
      echo '<div class="card">
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
      <br />';
    }
  } else {
    echo "Couldn't issue database query<br />";
    echo mysqli_error($response);
  }


  $mysqli->close();
 ?>


</body>
</html>
