<?php
  $db_host = "localhost";
  $db_user = "root";
  $db_passwd = "0000";
  $db_name = "movies";

  $conn = new mysqli ($db_host, $db_user, $db_passwd, $db_name);

  $managerID = $_POST["managerID"];
  $sql = "INSERT into manager values('$managerID')";
  $result = mysqli_query($conn, $sql);

  echo $result;
?>
