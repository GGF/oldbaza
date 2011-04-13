<?
// Îעמבנאזאוע מעקוע
echo "<form method=get id=form action=''>";
echo "<input type=hidden name='o1'>";
echo "Îעקוע חא לוסÿצ:";

$sql="SELECT MONTH(ddate), YEAR(ddate) FROM (sk_".$sklad."_dvizh) GROUP BY MONTH(ddate),YEAR(ddate)";
$res=mysql_query($sql);
//echo $sql."<br>";
echo "<select onchange=\"$('#submit').click()\" id=month name=month>";
while($rs=mysql_fetch_array($res)) {
	echo "<option value=".($rs[0]*10000+$rs[1])." ".((floor($month/10000)==$rs[0] && ($month%10000)==$rs[1])?"SELECTED":"").">".sprintf("%02d",$rs[0])."-".$rs[1]."</option>";
}
$sql="SELECT MONTH(ddate), YEAR(ddate) FROM (sk_".$sklad."_dvizh_arc) GROUP BY YEAR(ddate),MONTH(ddate) ORDER BY YEAR(ddate) DESC, MONTH(ddate) DESC";
$res=mysql_query($sql);
//echo $sql."<br>";
while($rs=mysql_fetch_array($res)) {
	echo "<option value=".($rs[0]*10000+$rs[1])." ".((floor($month/10000)==$rs[0] && ($month%10000)==$rs[1])?"SELECTED":"").">".sprintf("%02d",$rs[0])."-".$rs[1]."</option>";
}
echo "</select><input id=submit type=submit value='Îעקוע' ></form>";

if (!isset($sdate)) $sdate = date("d.m.Y");
if (!isset($edate)) $edate = date("d.m.Y");

echo "<form method=get id=form action=''>";
echo "<input type=hidden name='o1'>";
echo "<input type=hidden name='range'>";
echo "Îעקוע חא ןונטמה: ס ";
echo "<input size=10 id='datepicker'  name='sdate' value='{$sdate}' type=text >";
echo " ןמ ";
echo "<input size=10 id='datepicker1'  name='edate' value='{$edate}' type=text >";
echo "<input id=submit type=submit value='Îעקוע'>";
echo "</form>";
//echo "<script>$('#datepicker').datepicker()</script>";

if (isset($month)) {
	include "o1_month.php";
} 
if (isset($range)) {
	include "o1_range.php";
} 

?>