<?php
$db_host = "localhost";
$db_user = "root";
$db_passwd = "0000";
$db_name = "movies";

$conn = new mysqli($db_host, $db_user, $db_passwd, $db_name);

if ($conn->connect_errno) {
    die('Connection Error : '.$conn->connect_error);
} else {
    echo "<center>DB 연결 완료!!</center>";
}


  $name = $_POST['name'];
  $age = $_POST['age'];
  $id = $_POST['id'];
  $pw = $_POST['pw'];

  //상단 메뉴바 userid
  $userid = $_POST['userid']; //다른 페이지 창에서
  $userid1 = $_POST['id']; //회원가입창에서
  $userid2 = $_POST['id2']; //로그인창에서

  //회원가입 DB
  $sql = "INSERT INTO member values('$id','$pw','$name',$age)";
  echo $sql."<br>";
  mysqli_query($conn, $sql);

  //평가하기
  $sql = "select * from movies where title not in (select title from star_point where id = '$userid') order by rand()";
  $result = mysqli_query($conn, $sql);

  $list = '';
  $i = 0; $len=0;

  while ($row = mysqli_fetch_array($result)) {
      $list = $list."<tr>";
      $list = $list."<td id='titleId${i}'>{$row['Title']}</td>";
      $list = $list."<td>{$row['Nation']}</td>";
      $list = $list."<td>{$row['Director']}</td>";
      $list = $list."<td>{$row['Actor']}</td>";
      $list = $list."<td> <select id='pointId${i}' name='pointId${i}' onchange='movie_count(${i},pointId${i}.value)'><option selected>별점</option><option value='1'>1 점</option><option value='2'>2 점</option><option value='3'>3 점</option><option value='4'>4 점</option><option value='5'>5 점</option></select> </td>";
      $list = $list."</tr>";
      $i++;
  }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="style/PickVi_taste_mypage.css" />
</head>

<body>
  <nav class="bar">
    <form id="nav-form" method="POST">
     <div class="bar_contents">
         <div class="menu">
           <span id="logo">
             <input id="logoInput" type="button" value="" onclick="menu_route(1)"/>
           </span>

           <div id="logo_hrizon"> </div>

           <div id="menu-list">
               <ul>
                 <li><input id="home" type="button" value="홈" onclick="menu_route(2)"/></li>
                 <li><input id="category" type="button" value="카테고리" onclick="menu_route(3)"/></li>
                 <li><input id="taste" type="button" value="평가하기" onclick="menu_route(4)"/></li>
               </ul>
           </div>
         </div>
         <div class="find_text">
           <input id="TextFind" name="textfindeName" tpye="text" placeholder="검색" onclick="changeTextFind()" onblur="changeTextFind()" onkeyup="press()"/>
         </div>
         <div class="bar_logoes">
           <span class="username">
              <p><input type="text" name="userid" id="userid"> 님,</p>
           </span>
           <span id="profile-logo">
               <input id="profile" type="button" value=""  onclick="menu_route(5)"/>
           </span>
         </div>
     </div>
      <div class="movie-count">
        <blockquote>
          <p>10개 이상의 영화를 선택해줘야 취향 분석이 가능해요 !</p>
        </blockquote>
          <div id="evaluation-button">
            <h3><div id="count"></div></h3>
            <input type="button" value="취향 분석" onclick ="point_insert()"  />
          </div>
      </div>
    </form>
  </nav>

  <div class="container">
    <table>
      <thead>
        <tr>
          <th>제목</th>
          <th>국가</th>
          <th>감독</th>
          <th>배우</th>
          <th>나의 별점</th>
        </tr>
      </thead>
      <tbody id="tbody-id">
        <!-- 반복문 출력 -->
      </form>
      </tbody>
    </table>
    <input id="more" type="button" value="더 보기" />
  </div>
</body>
<script>
  //상단 바  id 출력
  var html_userid ="<?=$userid?>";
  var html_userid1 ="<?=$userid1?>";
  var html_userid2 ="<?=$userid2?>";
  var useridId = document.getElementById('userid');

  if(html_userid1=="" && html_userid=="" ){
    useridId.value = html_userid2;
  }
  else if(html_userid2=="" && html_userid==""){
    useridId.value = html_userid1;
  }
  else{
    useridId.value = html_userid;
  }

  //nav - menu이동
  function menu_route(n){
    if(n==1 || n==2)
    {
      document.getElementById("nav-form").action ="PickVi_main.php";
      document.getElementById("nav-form").submit();
    }
    else if(n==3)
    {
      document.getElementById("nav-form").action ="PickVi_category.php";
      document.getElementById("nav-form").submit();
    }
    else if(n==4)
    {
      document.getElementById("nav-form").action ="PickVi_Taste.php";
      document.getElementById("nav-form").submit();
    }
    else if(n==5)
    {
      document.getElementById("nav-form").action ="PickVi_mypage.php";
      document.getElementById("nav-form").submit();
    }
  }


  //영화 list 출력
  var html = "<?=$list?>";
  document.getElementById('tbody-id').innerHTML = html;


  var count = 0; //취향 분석 버튼 옆 숫자 버튼 count
  var totalLen = <?=$i?>; // 영화 리스트 총 길이
  var flag = new Array(); // 별점 매겼을때 T,F로 측정
  for(var j=0;j<totalLen;j++)
  {
    flag[j] = false;
  }

  function movie_count(i,values) {
    if(flag[i]==false) //방문 안 한곳일 때만
    {
      flag[i]=true; //방문으로 변경 후
      count++; // count up
      document.getElementById('count').innerHTML = count;
    }
    if(flag[i]==true && values=='별점') // 방문 했는데, '별점'으로 바꿨을 경우
    {
      count--; // count down
      document.getElementById('count').innerHTML = count;
    }
  }



  function point_insert(){
    if(count>=10) // 10개 이상 별점을 매겼을 때만
    {
      //별점 insert
      var useridVal  = useridId.value;
      var xhr = new Array();

      for(var i =0; i<totalLen;i++)
      {
            var titleId = document.getElementById(`titleId${i}`);
            var titleVal = titleId.childNodes[0].nodeValue;

            var pointId = document.getElementById(`pointId${i}`);
            var pointVal = pointId.value;

            if(pointVal != "별점")
            {
              xhr[i] = new XMLHttpRequest();
              xhr[i].open("POST", "php/PickVi_check3.php", true);
              xhr[i].setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

              xhr[i].send("pointVal=" + pointVal + "&" + "titleVal=" + titleVal + "&" + "useridVal=" + useridVal);
            }
      }
      menu_route(1);
    }
    else
    {
      alert("10개 이상의 별점을 매겨주세요 !");
    }


  }


</script>
<script src="js/findText.js">  </script>
</html>
