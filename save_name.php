<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "RS");
if (mysqli_connect_errno()) {
  print("Connect failed: %s\n" . mysqli_connect_error());
  exit();
}
if(isset($_POST["courseTitle"]) {
  $courseTitle = $_POST["courseTitle"];
  $courseTitle = trim(preg_replace('/ +/', ' ', preg_replace('/$preachievementname[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($courseTitle))))));
  $latest = $_SESSION["course"];
  $sql = "UPDATE course SET name='" . $courseTitle . "' WHERE creator='" . $latest . "';";
  mysqli_query($mysqli,$sql);
}
?>
