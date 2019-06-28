<?php
$db_host = "localhost";
$db_user = "root";
$db_passwd = "0000";
$db_name = "movies";

$conn = new mysqli($db_host, $db_user, $db_passwd, $db_name);

//상단 id
$userid = $_POST['userid'];

//카테고리 출력
$sql = "select * from movies left join avg_point using(title) order by rand()";
$result = mysqli_query($conn, $sql);
$list = '';
$i = 0; $len=0;
while ($row = mysqli_fetch_array($result)) {
    $list = $list."<tr>";
    $list = $list."<td>{$row['Title']}</td>";
    $list = $list."<td>{$row['Nation']}</td>";
    $list = $list."<td>{$row['Age']}</td>";
    $list = $list."<td>{$row['point']}</td>";
    $list = $list."</tr>";
    $i++;
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
<meta charset="utf-8">
<title></title>
<link rel="stylesheet" href="style/PickVi_category_main_text.css" />
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
 </form>
</nav>

<div class="container">
  <form>
  <select id = "genreId" name = "genrename">
    <option selected>장르</option>
    <option value="Animation">애니메이션</option>
    <option value="Horror">공포</option>
    <option value="Romance">로맨스</option>
    <option value="Fantasy">판타지</option>
    <option value="Hero">히어로</option>
    <option value="Comedy">코미디</option>
    <option value="Drama">드라마</option>
    <option value="Thriller">스릴러</option>
    <option value="Action">액션</option>
    <option value="Adult">성인</option>
  </select>
  <select id = "nationId" name = "nationname">
    <option selected>국가</option>
    <option>한국</option>
    <option>미국</option>
    <option>영국</option>
    <option>프랑스</option>
    <option>뉴질랜드</option>
    <option>오스트리아</option>
    <option>독일</option>
    <option>캐나다</option>
    <option>대만</option>
  </select>
  <select id = "ageId" name = "agename">
    <option selected>연령</option>
    <option value="0">전체관람가</option>
    <option value="12">12세 관람가</option>
    <option value="15">15세 관람가</option>
    <option value="19">청소년 관람불가</option>
  </select>
  <input type ="button" onclick="inquiry()" value="조회">
</form>
  <table>
    <thead>
      <tr>
        <th>제목</th>
        <th>국가</th>
        <th>연령</th>
        <th>별점</th>
      </tr>
    </thead>
    <tbody id="tbody-id">
      <!-- 반복문 출력 -->
        <?=$list?>
    </form>
    </tbody>
  </table>
  <input id="more" type="button" value="더 보기" />
</div>
</body>
<script >
//상단 id
var html_userid ="<?=$userid?>";
var useridVal = document.getElementById('userid');
useridVal.value = html_userid;

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

//취향 분석 버튼 옆 숫자 버튼 count
var count = 0;
var html ="";
function inquiry() {

  //카테고리 변수
  var genreIdVal = genreId.value;
  var nationIdVal = nationId.value;
  var ageIdVal = ageId.value;
  //console.log(pointVal);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "php/PickVi_category_genre.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
    //var result = JSON.parse(xhr.responseText); // reponseText : PHP응답한 결과 값
    //console.log(result);
    if(xhr.readyState == 4 && xhr.status == 200) { // 응답에 성공하면
      html = xhr.responseText;
      document.getElementById('tbody-id').innerHTML = html;
    }
    else { //응답에 실패하면
      console.error("error.");
    }
  }
  xhr.send("genreIdVal=" + genreIdVal + "&" + "nationIdVal=" + nationIdVal+ "&" + "ageIdVal=" + ageIdVal);
}
</script>
<script src="js/findText.js">  </script>
</html>
