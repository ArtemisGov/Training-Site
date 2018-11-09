<?php
error_reporting(E_ALL ^ E_NOTICE);
if (empty($user_name)) $user_name = '';
    $connection = @mysqli_connect("localhost","root","","RS");
    if($connection->connect_error){//show error if connection failed
        die("Connection failed: " . $connection->connect_error);
    }
    $sql="SELECT username, usrid FROM userinfo WHERE username LIKE '%" . $_POST['search'] . "%';";
    $res=$connection->query($sql);
    while($searchRow=$res->fetch_assoc()){
        echo "<a style='position:relative;' href='profilet.php?user=" . $searchRow['usrid'] . "'> " . $searchRow['username'] . "</a>";
    }
    mysqli_close($connection);
?>
