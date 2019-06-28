<?php
$db_host = "localhost";
$db_user = "root";
$db_passwd = "0000";
$db_name = "movies";

$conn = new mysqli ($db_host, $db_user, $db_passwd, $db_name);

if ($conn->connect_errno) {
    die('Connection Error : '.$conn->connect_error);
} else {

}

$Genre_name = $_POST['genreIdVal'];
$age_name = $_POST['ageIdVal'];
$nation_name = $_POST['nationIdVal'];

if($Genre_name != '장르'){
  $sql = "select * from movies m left join avg_point a on m.title = a.title
  inner join genre g on m.title = g.title where $Genre_name = 1";
  if($age_name != '연령'){
    $sql = $sql." and m.age = $age_name";
  }
  if($nation_name != '국가'){
    $sql = $sql." and m.nation = '$nation_name'";
  }
}

else{
  $sql = "select * from movies left join avg_point using(title)";
  if($age_name != '연령' && $nation_name != '국가'){
    $sql = $sql." where age = $age_name and nation = '$nation_name'";
  }
  else if($age_name == '연령' && $nation_name != '국가'){
    $sql = $sql." where nation = '$nation_name'";
  }
  else if($age_name != '연령' && $nation_name == '국가'){
    $sql = $sql." where age = $age_name";
  }
}

//echo $sql;

$result = mysqli_query($conn, $sql);
$list = '';
while ($row = mysqli_fetch_array($result)) {
  $list = $list."<tr>";
  $list = $list."<td>{$row['Title']}</td>";
  $list = $list."<td>{$row['Nation']}</td>";
  $list = $list."<td>{$row['Age']}</td>";
  $list = $list."<td>{$row['point']}</td>";
  $list = $list."</tr>";
}
echo $list;
?>
