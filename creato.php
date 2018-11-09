<?php
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
?>
