<?php
$mysqli = new mysqli("localhost", "root", "", "RS");
if (mysqli_connect_errno()) {
  print("Connect failed: %s\n" . mysqli_connect_error());
  exit();
}
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
if ($lang == "en" or $lang == NULL) {
  $nav = array("Home","About","Jobs", "Learn","Login","Contact","Profile","Logout","Settings");
} elseif ($lang == "pt") {
  $nav = array("Início","Sobre nós","Trabalhos","Aprende","Entrar","Contactos","Profile","Logout","Settings");
} elseif ($lang == "eo") {
  $nav = array("Ĉefpaĝo","Pri Ni","Laboro","Lernu","Ensaluti","Kontaktu","Profilo","Elsaluti","Agordoj");
}

$avatar = '';
if (isset($_SESSION["session"])) {
$id = $_SESSION['usrid'];
$userQuery = "SELECT profilePicture FROM userinfo WHERE usrid='" . $id . "';";
$userResponse = @mysqli_query($mysqli,$userQuery);
$userRow = @mysqli_fetch_array($userResponse);
$avatar = $userRow['profilePicture'];
}
?>
<ul>
  <li><a href="" style="margin-right: 30px;"><?php echo $nav[5]; ?></a></li>
  <?php
  session_start();
  if (isset($_SESSION["session"])) {
    echo '<li><a href="learn.php" style="">' . $nav[3] . '</a></li>';
  } else {
    echo '<li><a href="login.php" style="">' . $nav[4] . '</a></li>';
  }
  ?>
  <li><a href="" style=""><?php echo $nav[1]; ?></a></li>
  <li><a href="index.php"><?php echo $nav[0]; ?></a></li>
  <?php
  if (isset($_SESSION["session"])) {
  echo '
  <li class="left">
    <button id="rando">';}
    if (isset($_SESSION["session"])) {
      if ($avatar != 0 or $avatar != NULL) {
        echo "<div id='Avatarwrapper'><img src=" . $avatar . " alt='avatar' id='menuAvatar' /></div>";
      } else {
        echo "<div id='Avatarwrapper'><img src='logopic.png' alt='avatar' id='menuAvatar' /></div>";
      }
    }
  if (isset($_SESSION["session"])) {
  echo '</button>
      <div class="dropdown-content">
        <a href="profilet.php?user=' . $_SESSION["usrid"] . '">' . $nav[6] . '</a>
        <a href="kill.php">' . $nav[7] . '</a>
        <a href="#">' . $nav[8] . '</a>
      </div>
  </li>';
}
   ?>
</ul>
