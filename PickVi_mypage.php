<!DOCTYPE html>
<html lang="en" dir="ltr">
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
  //상단 메뉴바 userid
  $userid = $_POST['userid']; //다른 페이지 창에서

  //내가 평가한 별점
  $sql = "select * from movies m join star_point s using(title) where id = '$userid'";
  $result = mysqli_query($conn, $sql);
  $list = '';
  $i = 0; $len=0;

  while ($row = mysqli_fetch_array($result)) {
      $list = $list."<tr>";
      $list = $list."<td id='titleId${i}'>{$row['Title']}</td>";
      $list = $list."<td>{$row['Nation']}</td>";
      $list = $list."<td>{$row['Director']}</td>";
      $list = $list."<td>{$row['Actor']}</td>";
      //$list = $list."<td>{$row['Point']}</td>";
      $my_point = $row['Point'];
      if ($my_point == 1) {
          $list = $list."<td> <select id='pointId${i}' name='pointId${i}'><option value='1' selected>1 점</option><option value='2'>2 점</option><option value='3'>3 점</option><option value='4'>4 점</option><option value='5'>5 점</option><option value='del'>삭제</option></select> </td>";
      } elseif ($my_point == 2) {
          $list = $list."<td> <select id='pointId${i}' name='pointId${i}'><option value='1'>1 점</option><option value='2' selected>2 점</option><option value='3'>3 점</option><option value='4'>4 점</option><option value='5'>5 점</option><option value='del'>삭제</option></select> </td>";
      } elseif ($my_point == 3) {
          $list = $list."<td> <select id='pointId${i}' name='pointId${i}'><option value='1'>1 점</option><option value='2'>2 점</option><option value='3' selected>3 점</option><option value='4'>4 점</option><option value='5'>5 점</option><option value='del'>삭제</option></select> </td>";
      } elseif ($my_point == 4) {
          $list = $list."<td> <select id='pointId${i}' name='pointId${i}'><option value='1'>1 점</option><option value='2'>2 점</option><option value='3'>3 점</option><option value='4' selected>4 점</option><option value='5'>5 점</option><option value='del'>삭제</option></select> </td>";
      } elseif ($my_point == 5) {
          $list = $list."<td> <select id='pointId${i}' name='pointId${i}'><option value='1'>1 점</option><option value='2'>2 점</option><option value='3'>3 점</option><option value='4'>4 점</option><option value='5' selected>5 점</option><option value='del'>삭제</option></select> </td>";
      }
      $list = $list."</tr>";
      $i++;
  }

  //사용자 정보 가져오기
  $sql2 = "select * from member where id = '$userid'";
  $result2 = mysqli_query($conn, $sql2);
  $row = mysqli_fetch_array($result2);
  $name = $row['Name'];
  $age = $row['age'];
  $pw = $row['PW'];

?>
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
            <p>별점을 수정해보세요 !</p>
          </blockquote>
            <div id="evaluation-button">
              <input type="button" value="별점 수정" onclick ="point_Modify()"  />
            </div>
        </div>

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
        </tbody>
      </table>

      <div id="user-info">
          <fieldset style="width:400px;margin: 0 auto; margin-top: 90px;">
            <legend>사용자 정보</legend>
            이름 : &nbsp; <span style="font-weight: bold;" id="username"></span> <br><br>
            아이디 : &nbsp; <span style="font-weight: bold;" id="idId"></span> <br><br>
            나이 : &nbsp;  <span style="font-weight: bold;" id="age"></span> <br><br>
            비밀번호 : &nbsp; <input style="font-weight: bold;" id="pw" name="pwName" type="password" size="15"  /><br><br>
            <input id="pwModify" type="button" value="비밀번호 수정" onclick="pwFunction()" />
            <br />
          </fieldset>
        </form>
      </div>
    </div>

  </body>
  <script>
  //상단 id
  var html_userid ="<?=$userid?>";
  var useridVal = document.getElementById('userid');
  useridVal.value = html_userid;

  //user 정보
  var html_username ="<?=$name?>";
  document.getElementById('username').innerHTML = html_username;

  var html_userage ="<?=$age?>";
  document.getElementById('age').innerHTML = html_userage;

  var html_userpw ="<?=$pw?>";
  var userpwVal = document.getElementById('pw');
  userpwVal.value = html_userpw;

  document.getElementById('idId').innerHTML = html_userid;

  //비밀번호 수정
  function pwFunction(){
    var userpwVal = document.getElementById('pw');
    var userpw = userpwVal.value;
    var userid ="<?=$userid?>";
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/PickVi_pwModify.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send("userid=" + userid +"&"+ "userpw=" +userpw);

    document.getElementById("nav-form").action ="/php/PickVi_pwModify.php";
    document.getElementById("nav-form").submit();
    menu_route(5);
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
      document.getElementById("nav-form").action ="PickVi_taste.php";
      document.getElementById("nav-form").submit();
    }
    else if(n==5)
    {
      document.getElementById("nav-form").action ="PickVi_mypage.php";
      document.getElementById("nav-form").submit();
    }
  }

  var html = "<?=$list?>";
  document.getElementById('tbody-id').innerHTML = html;


  var useridVal = document.getElementById('userid');
  var totalLen = <?=$i?>; // 영화 리스트 총 길이

  function point_Modify(){
    //별점 insert
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
            xhr[i].open("POST", "php/PickVi_modify.php", true);
            xhr[i].setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr[i].send("pointVal=" + pointVal + "&" + "titleVal=" + titleVal + "&" + "useridVal=" + useridVal.value);
          }
      }
    document.getElementById("nav-form").submit();
    document.getElementById("nav-form").action ="PickVi_mypage.php";
  }

  </script>

  <script src="js/findText.js">  </script>
</html>
