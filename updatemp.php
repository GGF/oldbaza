<?
$_SERVER["debugAPI"] = false;
include_once $_SERVER["DOCUMENT_ROOT"]."/lib/sql.php"; // это нужно так как не вызывается заголовк html

$sql="SELECT posintz.id as posid, masterplate.id as mpid FROM posintz JOIN masterplate ON (masterplate.tz_id=posintz.tz_id AND masterplate.posintz=posintz.posintz)";
$res=mysql_query($sql);
while ($rs=mysql_fetch_array($res)) {
	$sql="UPDATE masterplate SET posid='".$rs["posid"]."' WHERE id='".$rs["mpid"]."'";
	mysql_query($sql);
}

?>
