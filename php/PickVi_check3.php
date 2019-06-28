<?php
  $db_host = "localhost";
  $db_user = "root";
  $db_passwd = "0000";
  $db_name = "movies";

  $conn = new mysqli ($db_host, $db_user, $db_passwd, $db_name);

  $pointVal = $_POST["pointVal"];
  $titleVal = $_POST["titleVal"];
  $useridVal = $_POST["useridVal"];

  $sql = "INSERT INTO star_point VALUES ('$titleVal','$useridVal',$pointVal)";
  echo $sql."<br>";
  mysqli_query($conn,$sql);

?>
