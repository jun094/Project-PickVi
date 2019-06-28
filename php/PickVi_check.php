<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_passwd = "0000";
    $db_name = "movies";

    $conn = new mysqli ($db_host, $db_user, $db_passwd, $db_name);


    // 중복 아이디 검사 php -> 중복아이디 없을때 0 / 있으면 1이상
    if ($conn->connect_errno) {
        die('Connection Error : '.$conn->connect_error);
    }
    else { }

    $id = $_POST["id"];
    $sql = "SELECT COUNT(*) FROM member WHERE ID='$id'";
    $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_array($result)) {
       echo $row['COUNT(*)'];
      }


?>
