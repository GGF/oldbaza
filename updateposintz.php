<?
$GLOBALS["debugAPI"] = true;
include_once $GLOBALS["DOCUMENT_ROOT"]."/lib/sql.php"; // это нужно так как не вызывается заголовк html
//echo "111";

$sql="SELECT * FROM posintz WHERE pitz_psimat LIKE '%2F%'";
$res=mysql_query($sql);
while ($rs=mysql_fetch_array($res)) {
		$sql="UPDATE posintz SET pitz_psimat='".str_replace('%%2F','/',$rs["pitz_psimat"])."',pitz_mater='".str_replace('%%2F','/',$rs["pitz_mater"])."' WHERE id='".$rs["id"]."'";
		mysql_query($sql);
		echo $sql;
		//echo $rs["id"]."__".$rs1["id"]."<br>";
		}

?>
