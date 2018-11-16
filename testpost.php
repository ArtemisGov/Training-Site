<?php
$mysqli = new mysqli("localhost", "root", "", "RS");
if (mysqli_connect_errno()) {
  print("Connect failed: %s\n" . mysqli_connect_error());
  exit();
}
  if(isset($_POST['submit'])) {
    $courseName = $_POST['title'];
    $courseName = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($courseName))))));
    $updateName = "UPDATE course SET name = '" . $courseName . "' WHERE creator='" . $usrid . "' AND id='" . $latest . "';";
    mysqli_query($mysqli,$updateName);
  }
 ?>
