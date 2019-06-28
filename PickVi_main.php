<?php
$db_host = "localhost";
$db_user = "root";
$db_passwd = "0000";
$db_name = "movies";

$conn = new mysqli($db_host, $db_user, $db_passwd, $db_name);

///////////상단 id
$userid = $_POST['userid'];


///////// 장르 취향 분석
// 1. 취향 분석 뷰 생성 -> 페이지 load할때 view생성
$sql1 = "create view ".$userid."_tempView as select s.id, sum(g.animation*s.point)
        Animation, sum(g.horror*s.point) Horror, sum(g.romance*s.point) Romance, sum(g.fantasy*s.point) Fantasy,
        sum(g.Drama*s.point) as Drama, sum(g.Hero*s.point) as Hero, sum(g.Comedy*s.point) as
        Comedy, sum(g.Thriller*s.point) as Thriller, sum(g.Action*s.point) as Action, sum(g.Adult*s.point) as
        Adult from star_point s join genre g on s.title = g.title where s.id = '$userid'";
$result1 = mysqli_query($conn, $sql1);


// 2. 취향분석 뷰를 행열 바꾼 뷰 생성
$sql2 = "CREATE VIEW ".$userid."_pointes AS select id, case when x=1 then 'Animation' when x=2 then 'Horror' when x=3 then 'Romance' when x=4 then 'Fantasy'
        when x=5 then 'Hero' when x=6 then 'Comedy' when x=7 then 'Drama' when x=8 then 'Thriller' when x=9 then 'Action' when x=10 then 'Adult' end genre, case when x=1
        then Animation when x=2 then Horror when x=3 then Romance when x=4 then Fantasy when x=5 then Hero when x=6 then Comedy when x=7 then Drama
        when x=8 then Thriller when x=9 then Action when x=10 then Adult end value from ( select * from ".$userid."_tempView a, (select 1 as x union all select 2 as x union all
        select 3 as x union all select 4 as x union all select 5 as x union all select 6 as x union all select 7 as x union all select 8 as x
        union all select 9 as x union all select 10 as x  ) b ) a order by value desc limit 2";
$result2 = mysqli_query($conn, $sql2);

// 3. 상위 2개 장르만 뽑아옴
$sql3 = "SELECT * FROM ".$userid."_pointes";
$result3 = mysqli_query($conn, $sql3);

$i  = 0;
while ($row = mysqli_fetch_array($result3)) {
  $genre[$i] = $row['genre'];
  $i++;
}

// 4. 상위 2개 장르랑 movies 테이블이랑 innnerjoin해서 최종 출력
$sql4 = "select m.title, m.nation, m.director, m.actor, m.age, a.point
         from movies m inner join genre g
         on g.title = m. title
         left join avg_point a
         on m.title = a.title
         where g.".$genre[0]." = 1
         order by rand()
         limit 10";
$result4 = mysqli_query($conn, $sql4);
$list0 = '';
while ($row = mysqli_fetch_array($result4)) {
  $list0 = $list0."<tr>";
  $list0 = $list0."<td>{$row['title']}</td>";
  $list0 = $list0."<td>{$row['nation']}</td>";
  $list0 = $list0."<td>{$row['director']}</td>";
  $list0 = $list0."<td>{$row['actor']}</td>";
  $list0 = $list0."<td>{$row['age']}</td>";
  $list0 = $list0."<td>{$row['point']}</td>";
  $list0 = $list0."</tr>";
}
$sql5 = "select m.title, m.nation, m.director, m.actor, m.age, a.point
         from movies m inner join genre g
         on g.title = m. title
         left join avg_point a
         on m.title = a.title
         where g.".$genre[1]." = 1
         order by rand()
         limit 10";
$result5 = mysqli_query($conn, $sql5);
$list1 = '';
while ($row = mysqli_fetch_array($result5)) {
  $list1 = $list1."<tr>";
  $list1 = $list1."<td>{$row['title']}</td>";
  $list1 = $list1."<td>{$row['nation']}</td>";
  $list1 = $list1."<td>{$row['director']}</td>";
  $list1 = $list1."<td>{$row['actor']}</td>";
  $list1 = $list1."<td>{$row['age']}</td>";
  $list1 = $list1."<td>{$row['point']}</td>";
  $list1 = $list1."</tr>";
}
?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">

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
      <!-- 첫번째 장르 추천 -->
      <table>
        <h4> <?=$userid?>님이 좋아하는 '<?=$genre[0]?>' 장르의 영화 입니다 !</h4>
        <thead>
          <tr>
            <th>제목</th>
            <th>국가</th>
            <th>감독</th>
            <th>배우</th>
            <th>연령</th>
            <th>평균 별점</th>
          </tr>
        </thead>
        <tbody id="tbody-genre0">
          <!-- 반복문 출력 -->
        </tbody>
      </table>

      <!-- 두번째 장르 추천 -->
      <table>
        <h4> <?=$userid?>님이 좋아하는 '<?=$genre[1]?>' 장르의 영화 입니다 !</h4>
        <thead>
          <tr>
            <th>제목</th>
            <th>국가</th>
            <th>감독</th>
            <th>배우</th>
            <th>연령</th>
            <th>평균 별점</th>
          </tr>
        </thead>
        <tbody id="tbody-genre1">
          <!-- 반복문 출력 -->
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

    //장르 list 출력
    var html0 = "<?=$list0?>";
    document.getElementById('tbody-genre0').innerHTML = html0;

    var html1 = "<?=$list1?>";
    document.getElementById('tbody-genre1').innerHTML = html1;
  </script>
  <script src="/js/findText.js">  </script>
</html>
