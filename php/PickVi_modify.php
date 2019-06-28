<?php
  $db_host = "localhost";
  $db_user = "root";
  $db_passwd = "0000";
  $db_name = "movies";

  $conn = new mysqli ($db_host, $db_user, $db_passwd, $db_name);

  $pointVal = $_POST["pointVal"];
  $titleVal = $_POST["titleVal"];
  $useridVal = $_POST["useridVal"];
  $totalLan = $_POST["$totalLan"];
  //$sql = "INSERT INTO star_point VALUES ('$titleVal','$useridVal',$pointVal)";
  if($pointVal == 'del'){
    $sql = "DELETE from star_point where title = '$titleVal' and id = '$useridVal'";
  }
  else{
    $sql = "UPDATE star_point set point = $pointVal where title = '$titleVal' and id = '$useridVal'";
  }
  echo "1";
  mysqli_query($conn,$sql);
?>
