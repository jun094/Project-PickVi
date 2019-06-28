<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_passwd = "0000";
    $db_name = "movies";

    $conn = new mysqli ($db_host, $db_user, $db_passwd, $db_name);

    // PW 검사 php
    $id = $_POST["id"];
    $pw = $_POST["pw"];

    $sql = "SELECT pw FROM member WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $db_passwd = mysqli_fetch_array($result);
    //echo $db_passwd['pw'];

    $sql2 = "select * from manager where id = '$id'";
    $result2 = mysqli_query($conn, $sql2);
    $db_manager = mysqli_fetch_array($result2);

    if($db_passwd['pw'] == $pw) {
      if($db_manager['ID'] == "$id" ) { //관리자면
        echo "2";
      }
      else {
        echo '1'; // 로그인 성공 = pw 일치하면 = 1
      }
    }
    else {
      echo '0'; // 로그인 실패 = pw 일치하지 않으면 = 0
    }
?>
