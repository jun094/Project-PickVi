<?php
  $db_host = "localhost";
  $db_user = "root";
  $db_passwd = "0000";
  $db_name = "movies";

  $conn = new mysqli ($db_host, $db_user, $db_passwd, $db_name);



  //비밀번호 수정
  $id = $_POST['userid'];
  $pw = $_POST['pwName'];

  $sql2 = "update member set PW = '$pw' where ID = '$id'";

  //echo $sql2."<br>";
  mysqli_query($conn,$sql2);
?>
<script>

</script>
