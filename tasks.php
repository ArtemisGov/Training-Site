<!DOCTYPE html>
<html>
<head>
  <title>

  </title>
  <style>
  .submit {
    width:600px;
    cursor: pointer;
    background-color: white;
    border-width: 0px;
    margin-left: -10%;
    padding: 10px;
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
  .searchWrap {
    border: solid 1px #6A6A6A;
    border-radius: 1px;
    padding: 4px;
    margin-top: 18px;
  }
  .navSearch {
    border-width: 0px;
    height: 25px;
    outline: none;
    font-size: 17.5px;
    color: #545454;
    width: 300px;
  }

  </style>
</head>
<body>
<?php
$mysqli = new mysqli("localhost", "root", "", "RS");

if (mysqli_connect_errno()) {
  print("Connect failed: %s\n" . mysqli_connect_error());
  exit();
}
if(isset($_POST['submit'])) {
  if($_POST['checkBox'] == 'TRUE') {
      $complete = 1;
  } else {
      $complete = 0;
  }

  $preachievementname = $_POST['achievementname'];
  $predescr = $_POST['descr'];
  $achievementname = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($preachievementname))))));
  $descr = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($predescr))))));
  $sql = "INSERT INTO achievements (achievementname, achievementdescr, usrid, complete) VALUES ('" . $achievementname . "', '" . $descr ."', '" . $userid . "','". $complete ."');";
  mysqli_query($mysqli,$sql);
  header("Refresh:0; url=profilet.php?user=". $userid . "");
}
 ?>

 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

 <ul>
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
   <li><a href="">Tasks</a></li>
   <li><a href="" style="">About</a></li>
   <li><a href="index.php">Home</a></li>
</ul>
<br /><br /><br />
<br /><br /><br />
<form method="post" id="post">
  <input type="text" class="form-control formName" name="achievementname" placeholder="Name">
  <textarea class="form-control txtarea" type="text" name="descr"  placeholder=" Description"></textarea>
  <input type="submit" value="Add a task" class="submit" id="submit"/>
</form>
</body>
</html>
