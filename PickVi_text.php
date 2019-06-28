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

$sql = "SELECT * FROM MOVIES
        where title like '%$text%'
        or nation like '%$text%'
        or director like '%$text%'
        or actor like '%$text%'
        or age like '%$text%'";
$result = mysqli_query($conn, $sql);

$list = '';
$i = 0;
while ($row = mysqli_fetch_array($result)) {
    $list = $list."<tr>";
    $list = $list."<td>{$row['Title']}</td>";
    $list = $list."<td>{$row['Nation']}</td>";
    $list = $list."<td>{$row['Director']}</td>";
    $list = $list."<td>{$row['Actor']}</td>";
    $list = $list."<td>{$row['Age']}</td>";
    $list = $list."</tr>";
    $i++;
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="style/PickVi_category_main_text.css" />

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
      <table>
        <div class="text-result">
          <p>검색하신 <strong>"<?=$text?>"</strong> 의 결과는 총
            <strong><?=$i?></strong> 건 입니다. </p>
        </div>
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
          <!-- 반복문 출력 -->
        </form>
        </tbody>
      </table>
    </div>
  </body>

  <script>
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
    var html = "<?=$list?>";
    document.getElementById('tbody-id').innerHTML = html;
  </script>
  <script src="/js/findText.js">  </script>

</html>
