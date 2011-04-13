<?
/*include_once $GLOBALS["DOCUMENT_ROOT"]."/lib/sql.php"; // это нужно так как при notop не вызывается заголовк html
authorize(); // вызов авторизации

showheader("Webcam");

//$menu = new Menu();

//$menu->show();


if  ($user=="igor") {
	echo "<div id=userswin class=sun style='display:none'>";
	$sql="SELECT *,(UNIX_TIMESTAMP()-UNIX_TIMESTAMP(ts)) AS lt FROM session JOIN users ON session.u_id=users.id";
	$res=mysql_query($sql);
	while($rs=mysql_fetch_array($res)){
		echo $rs[nik]." - ".$rs[lt]."<br>";
	}
	echo "</div>";
}
*/

//echo "<div class='maindiv' id=maindiv>";
echo "<img id=\"webcamimg\" src=\"img.php\"/ width=\"100%\">";
/*
echo "</div>";
echo "<div class='loading' id='loading'>Загрузка...</div>";

echo "<div class='editdiv' id=editdiv><img src=/picture/s_error2.png class='rigthtop' onclick='closeedit()'>";
echo "<div class='editdivin' id='editdivin'></div>";
echo "</div>";//место для редактирования всего
*/
echo "<script>newinterface=true;</script>";
echo "<script>function getimage() {
	window.location=\"http://".$_SERVER['HTTP_HOST']."/webcam/\";
	}
	setInterval('getimage()',15000);</script>";

//	showfooter();

?>