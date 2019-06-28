<?php
  $db_host = "localhost";
  $db_user = "root";
  $db_passwd = "0000";
  $db_name = "movies";

  $conn = new mysqli ($db_host, $db_user, $db_passwd, $db_name);

  $deltitle = $_POST["deltitle"];

  $sql = "DELETE from movies where title = '$deltitle'";
  $result = mysqli_query($conn, $sql);

  echo $result;
?>
