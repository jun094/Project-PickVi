<?php
$db_host = "localhost";
$db_user = "root";
$db_passwd = "0000";
$db_name = "movies";

$conn = new mysqli($db_host, $db_user, $db_passwd, $db_name);

//상단 id
$userid = $_POST['userid'];

//text find 값
$text = $_POST['textfindeName'];

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style/PickVi_category_main_text.css" />
  </head>
  <body>


    <div class="container">
      <h1 style="margin-bottom:100px;">관리자 페이지 입니다.</h1>
      <h3> 영화 등록 (장르는 1개만 선택 가능)</h3>
      <table>
        <thead>
          <tr>
            <th>제목</th>
            <th>국가</th>
            <th>감독</th>
            <th>배우</th>
            <th>연령</th>
          </tr>
        </thead>
        <tbody id="tbody-id">
          <form id="nav-form" method="POST">
          <tr>
            <th><input id ="title" name ="title" type ="text"/></th>
            <th><input id = "nation" name ="nation" type ="text"/></th>
            <th><input id = "director" name ="director" type ="text"/></th>
            <th><input id = "actor" name ="actor" type ="text"/></th>
            <th><select id = "ageId" name = "ageId">
              <option selected>연령</option>
              <option value="0">전체관람가</option>
              <option value="12">12세 관람가</option>
              <option value="15">15세 관람가</option>
              <option value="19">청소년 관람불가</option>
            </select></th>
          </tr>
          <tr>
            <th></th>
            <th><select id = "genreId1" name = "genre1">
              <option selected>장르1</option>
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
            </select></th>
            <th><select id = "genreId2" name = "genre2">
              <option selected>장르2</option>
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
            </select></th>
            <th colspan="2"><input type ="button" onclick="insertMovie()" value = "등록"></th>
          </tr>
        </form>
        </tbody>
      </table>

      <h3> 영화 삭제</h3>
      <table>
        <thead>
          <tr>
            <th>제목</th>
          </tr>
        </thead>
        <tbody id="tbody-id">
          <form id="nav-form" method="POST">
          <tr>
            <th><input id = "deltitle" name ="title" type ="text"/></th>
            <th><input type ="button" value = "삭제" onclick="deleteMovie()"></th>
          </tr>

        </form>
        </tbody>
      </table>

      <table>
        <h3> 관리자 임명</h3>
        <thead>
          <tr>
            <th>ID</th>
          </tr>
        </thead>
        <tbody id="tbody-id">
          <form id="nav-form" method="POST">
          <tr>
            <th><input id = "managerID" name ="managerID" type ="text"/></th>
            <th><input type ="button" onclick = "insertManager()" value = "등록"></th>
          </tr>
        </form>
        </tbody>
      </table>
    </div>
  </body>

  <script>

  function insertManager() {

    var managerID = document.getElementById('managerID').value;
    //console.log(pointVal);
    var bool = confirm(managerID + "님을 관리자로 등록 하시겠습니까?");
    if(bool){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/PickVi_manage_insertManager.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if(xhr.readyState == 4 && xhr.status == 200) { // 응답에 성공하면
        if(xhr.responseText) alert('등록 성공!');
        else alert('등록 실패!');
      }
      else { //응답에 실패하면
        console.error("error.");
      }
    }
    xhr.send("managerID=" + managerID);
    document.getElementById("nav-form").submit();
  }
  }

  function deleteMovie() {

    var deltitle = document.getElementById('deltitle').value;
    //console.log(pointVal);
    var bool = confirm(deltitle + "를 정말로 삭제하시겠습니까? 삭제하면 복구할 수 없습니다.");
    if(bool){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/PickVi_manage_deletemovie.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if(xhr.readyState == 4 && xhr.status == 200) { // 응답에 성공하면
        if(xhr.responseText) alert('삭제 성공!');
        else alert('삭제 실패!');
      }
      else { //응답에 실패하면
        console.error("error.");
      }
    }
    xhr.send("deltitle=" + deltitle);
    document.getElementById("nav-form").submit();
  }
}


  function insertMovie() {

    var title = document.getElementById('title').value;
    var nation = document.getElementById('nation').value;
    var director = document.getElementById('director').value;
    var actor = document.getElementById('actor').value;
    var age = document.getElementById('ageId').value;

    var genre1 = genreId1.value;
    var genre2 = genreId2.value;
    //console.log(pointVal);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/PickVi_manage_insertMovie.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if(xhr.readyState == 4 && xhr.status == 200) { // 응답에 성공하면
        if(xhr.responseText == 1) alert('등록 성공!');
        else if(xhr.responseText == 2) alert('장르를 한개 이상 선택해 주세요');
        else alert('등록 실패!');
      }
      else { //응답에 실패하면
        console.error("error.");
      }
    }
    xhr.send("title=" + title + "&" + "nation=" + nation+ "&" + "director=" + director + "&" + "actor=" + actor + "&" + "age=" + age + "&" + "genre1=" + genre1 + "&" + "genre2=" + genre2);
    document.getElementById("nav-form").submit();
  }


  </script>


</html>
