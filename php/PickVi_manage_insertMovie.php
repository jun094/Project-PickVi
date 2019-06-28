<?php
  $db_host = "localhost";
  $db_user = "root";
  $db_passwd = "0000";
  $db_name = "movies";

  $conn = new mysqli ($db_host, $db_user, $db_passwd, $db_name);

  $title = $_POST["title"];
  $nation = $_POST["nation"];
  $director = $_POST["director"];
  $actor = $_POST["actor"];
  $age = $_POST["age"];

  $genre1 = $_POST["genre1"];
  $genre2 = $_POST["genre2"];

  mysqli_query($conn, "start transaction");

  $sql1 = "INSERT into movies values('$title','$nation','$director','$actor',$age)";
  $result1 = mysqli_query($conn, $sql1);
  if($result1){
    if($genre1 == '장르1' && $genre2 == '장르2'){
      echo "2";
      return;
    }
    if($genre1 == '장르1'){
      $sql2 = "INSERT into genre($genre2,title) values(1,'$title')";
    }
    else if($genre2 == '장르2'){
      $sql2 = "INSERT into genre($genre1,title) values(1,'$title')";
    }
    else{
      $sql2 = "INSERT into genre($genre1,$genre2,title) values(1,1,'$title')";
    }
      $result2 = mysqli_query($conn, $sql2);
      if($result2) {
        mysqli_query($conn, "commit");
        echo "1";
      }
      else{
        mysqli_query($conn, "rollback");
        echo "0";
      }
  }else{
    mysqli_query($conn, "rollback");
    echo "0";
  }

?>
