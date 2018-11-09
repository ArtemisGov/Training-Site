<!DOCTYPE html>
<html>
<head>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <?php
    $search = $_GET['search'];
    $user = @$_GET['user'];
    $search = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($search))))));
    $user = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($user))))));
  ?>
  <title>
    <? echo $search;?> - Search
  </title>
  <style>
  .miniItemStyle {
    padding-left: 2px;
    padding-right: 2px;
    cursor: default;
    padding-top: 2px;
    padding-bottom: 2px;
    border-radius: 50%;
    height:10px;
    width:10px;
    display: inline-block;
    background-color: grey;
    color: white;
    float: right;
    margin-right: 3px;
    opacity: .8;
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
  .card-title {
    display:inline-block;
  }
  .card {
    margin-top: 5px;
    margin-left: 10px;
    padding: 0px;
  }
  .custom {
    margin-left: 10px;
    width: 50%;
  }
  .rightTab {
    float:right;
    height: 100%;
    width: 20px;
    display: inline-block;
    padding:20px;
  }
  .card-body {
    display: inline-block;
  }
  .miniProfile {
    float: right;
    width: 32%;
    display: inline-block;
    margin-right: 10px;
  }
  .result {
    display: inline-block;
    width: 50vw;
  }
  .itemStyle {
    padding-left: 20px;
    padding-right: 20px;
    cursor: default;
    padding-top: 10px;
    padding-bottom: 10px;
    display: inline-block;
    color: white;
    margin-top: 5px;
    opacity: .8;
  }
  </style>
</head>
<body>
  <br />
  <form action="search.php">
    <input class="form-control custom" type="text" name="search" id="bug"/>
    <input type="submit" id="rat" style="position: absolute; left: -9999px"/>
  </form>
  <div class="result">
  <?php
  error_reporting(E_ALL ^ E_NOTICE);

      $connection = @mysqli_connect("localhost","root","","RS");
      if($connection->connect_error){//show error if connection failed
          die("Connection failed: " . $connection->connect_error);
      }
      $sql="SELECT username, usrid, availability, reliability FROM userinfo WHERE username LIKE '%" . $search . "%';";
      $res=$connection->query($sql);
      $x = 0;

      while($row=$res->fetch_assoc()){
        $availability = $row['availability'];
        $reliability = $row['reliability'];
        $link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; //Possible security issue
        if (strpos($link, '&user=') !== false) {
            $link = substr($link, 0, -10);
        }



        echo "<div class='card'>
            <div class='card-body'>
              <h5 class='card-title'><a href='profilet.php?user=" . $row['usrid'] . "'>" . $row['username'] . "</a></h5><div class='rightTab' onclick='miniProfile()'><a href='" . $link . "&user=" . $row['usrid'] . "'> <i class='fas fa-angle-double-right'></i></a></div>";
              if ($reliability >= 4) {
                echo '<div class="miniItemStyle green" title="Very Reliable"> </div>';
              } elseif ($reliability > 3 && $reliability <= 4) {
                echo '<div class="miniItemStyle lime" title="Reliable"> </div>';
              } elseif ($reliability > 2 && $reliability <= 3)  {
                echo '<div class="miniItemStyle lemon" title="Avg. Reliablility"> </div>';
              } elseif ($reliability > 1 && $reliability <= 2)  {
                echo '<div class="miniItemStyle orange" title="Low Reliability"> </div>';
              } elseif ($reliability > 0 && $reliability <= 1)  {
                echo '<div class="miniItemStyle strawberry" title="Not Reliable"> </div>';
              }
              if ($availability >= 4) {
                echo '<div class="miniItemStyle green" title="Very Active"> </div>';
              } elseif ($availability > 3 && $availability <= 4) {
                echo '<div class="miniItemStyle lime" title="Active"> </div>';
              } elseif ($availability > 2 && $availability <= 3)  {
                  echo '<div class="miniItemStyle lemon" title="Avg. Activity"> </div>';
              } elseif ($availability > 1 && $availability <= 2)  {
                echo '<div class="miniItemStyle orange" title="Slow"> </div>';
              } elseif ($availability > 0 && $availability <= 1)  {
                echo '<div class="miniItemStyle strawberry" title="Inactive"> </div>';
              }
              echo "<p class='card-text'>" . $row['accDesc'] . "</p></div></div>";
      }

      $userQuery = "SELECT usrid, username, oldname, languages, joindate, art, hunting, frontwebdev, backwebdev, writing, programming, se, smm, pentesting, timezone, availability, reliability, profilePicture, wallpaper FROM userinfo WHERE usrid='" . $user . "';";
      $userResponse = @mysqli_query($connection,$userQuery);
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
      $pen = $userRow['pentesting'];
      mysqli_close($connection);

  ?>
</div><?php if ($user != NULL or $user != 0) {
  echo '<div class="card miniProfile">
  <div class="card-body">
    <h5 class="card-title">'; echo $username; echo '</h5>';
    echo '<h6 class="card-subtitle mb-2 text-muted">'; echo $oldname; echo'</h6>
    <p class="card-text">A short description of the user, this will also go on the user profile, however I don\'t have data for this, so for now it remain blank and this is a placeholder </p>
    <a href="#" class="card-link">More</a><br />';
    if ($hunter >= 4) {
      echo '<div class="itemStyle green" title="Excellent">Hunting </div>';
    } elseif ($hunter > 3 && $hunter <= 4) {
      echo '<div class="itemStyle lime" title="Above Average">Hunting </div>';
    } elseif ($hunter > 2 && $hunter <= 3)  {
        echo '<div class="itemStyle lemon" title="Average">Hunting </div>';
    } elseif ($hunter > 1 && $hunter <= 2)  {
      echo '<div class="itemStyle orange" title="Below Average">Hunting </div>';
    } elseif ($hunter >= 0 && $hunter <= 1)  {
      echo '<div class="itemStyle strawberry" title="Low">Hunting </div>';
    }
    echo "&nbsp;";
    if ($writing >= 4) {
      echo '<div class="itemStyle green" title="Excellent">SE </div>';
    } elseif ($writing > 3 && $writing <= 4) {
      echo '<div class="itemStyle lime" title="Above Average">SE </div>';
    } elseif ($writing > 2 && $writing <= 3)  {
        echo '<div class="itemStyle lemon" title="Average">SE </div>';
    } elseif ($writing > 1 && $writing <= 2)  {
      echo '<div class="itemStyle orange" title="Below Average">SE </div>';
    } elseif ($writing >= 0 && $writing <= 1)  {
      echo '<div class="itemStyle strawberry" title="Low">SE </div>';
    }
    echo "&nbsp;";
    if ($smm >= 4) {
      echo '<div class="itemStyle green" title="Excellent">SMM </div>';
    } elseif ($smm > 3 && $smm <= 4) {
      echo '<div class="itemStyle lime" title="Above Average">SMM </div>';
    } elseif ($smm > 2 && $smm <= 3)  {
        echo '<div class="itemStyle lemon" title="Average">SMM </div>';
    } elseif ($smm > 1 && $smm <= 2)  {
      echo '<div class="itemStyle orange" title="Below Average">SMM </div>';
    } elseif ($smm >= 0 && $smm <= 1)  {
      echo '<div class="itemStyle strawberry" title="Low">SMM </div>';
    }
    echo "&nbsp;";
    if ($webdev >= 4) {
      echo '<div class="itemStyle green" title="Excellent">Web Dev</div>';
    } elseif ($webdev > 3 && $webdev <= 4) {
      echo '<div class="itemStyle lime" title="Above Average">Web Dev</div>';
    } elseif ($webdev > 2 && $webdev <= 3)  {
        echo '<div class="itemStyle lemon" title="Average">Web Dev</div>';
    } elseif ($webdev > 1 && $webdev <= 2)  {
      echo '<div class="itemStyle orange" title="Below Average">Web Dev</div>';
    } elseif ($webdev >= 0 && $webdev <= 1)  {
      echo '<div class="itemStyle strawberry" title="Low">Web Dev</div>';
    }
    echo "&nbsp;";
    if ($art >= 4) {
      echo '<div class="itemStyle green" title="Excellent">Art</div>';
    } elseif ($art > 3 && $art <= 4) {
      echo '<div class="itemStyle lime" title="Above Average">Art</div>';
    } elseif ($art > 2 && $art <= 3)  {
        echo '<div class="itemStyle lemon" title="Average">Art</div>';
    } elseif ($art > 1 && $art <= 2)  {
      echo '<div class="itemStyle orange" title="Below Average">Art</div>';
    } elseif ($art >= 0 && $art <= 1)  {
      echo '<div class="itemStyle strawberry" title="Low">Art</div>';
    }
    echo "&nbsp;";
    if ($programming >= 4) {
      echo '<div class="itemStyle green" title="Excellent">Programming</div>';
    } elseif ($programming > 3 && $programming <= 4) {
      echo '<div class="itemStyle lime" title="Above Average">Programming</div>';
    } elseif ($programming > 2 && $programming <= 3)  {
        echo '<div class="itemStyle lemon" title="Average">Programming</div>';
    } elseif ($programming > 1 && $programming <= 2)  {
      echo '<div class="itemStyle orange" title="Below Average">Programming</div>';
    } elseif ($programming >= 0 && $programming <= 1)  {
      echo '<div class="itemStyle strawberry" title="Low">Programming</div>';
    }
    echo "&nbsp;";
    if ($writing >= 4) {
      echo '<div class="itemStyle green" title="Excellent">Writing</div>';
    } elseif ($writing > 3 && $writing <= 4) {
      echo '<div class="itemStyle lime" title="Above Average">Writing</div>';
    } elseif ($writing > 2 && $writing <= 3)  {
        echo '<div class="itemStyle lemon" title="Average">Writing</div>';
    } elseif ($writing > 1 && $writing <= 2)  {
      echo '<div class="itemStyle orange" title="Below Average">Writing</div>';
    } elseif ($writing >= 0 && $writing <= 1)  {
      echo '<div class="itemStyle strawberry" title="Low">Writing</div>';
    }
    echo "&nbsp;";
    if ($pen >= 4) {
      echo '<div class="itemStyle green" title="Excellent">Pen Testing</div>';
    } elseif ($pen > 3 && $pen <= 4) {
      echo '<div class="itemStyle lime" title="Above Average">Pen Testing</div>';
    } elseif ($pen > 2 && $pen <= 3)  {
        echo '<div class="itemStyle lemon" title="Average">Pen Testing</div>';
    } elseif ($pen > 1 && $pen <= 2)  {
      echo '<div class="itemStyle orange" title="Below Average">Pen Testing</div>';
    } elseif ($pen >= 0 && $pen <= 1)  {
      echo '<div class="itemStyle strawberry" title="Low">Pen Testing</div>';
    }
    echo '<div class="card-footer">
      <p class="card-text">
        <small class="text-muted">';
          echo "Joined: "; echo $userRow['joindate']; echo '
        </small>
      </p>
    </div>
  </div>
</div>
</body>
</html>';
}
?>
