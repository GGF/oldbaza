<?
	
	$sql="SELECT *,sk_".$sklad."_spr.id FROM sk_".$sklad."_spr JOIN sk_".$sklad."_ost ON sk_".$sklad."_ost.spr_id=sk_".$sklad."_spr.id WHERE nazv<>'' ORDER BY nazv";
	$res = mysql_query($sql);
	echo "<table class='listtable' cellspacing=0 cellpadding=0>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Наименование<th>Приход<th>Расход<th>Остаток на сегодня<th>Ед.изм.";
	echo "<tbody>";
	
	while ($rs=mysql_fetch_array($res)) {
		$prih = 0;
		$rash = 0;
		$sql = "SELECT SUM(quant) as prihod FROM (sk_".$sklad."_dvizh) JOIN sk_".$sklad."_spr ON (sk_".$sklad."_spr.id=sk_".$sklad."_dvizh.spr_id) WHERE MONTH(ddate)=(FLOOR($month/10000)) AND YEAR(ddate)=($month%10000) AND sk_".$sklad."_spr.id='".$rs["id"]."' AND type='1' AND numd<>'9999' GROUP BY sk_".$sklad."_spr.id";
		$res1 = mysql_query($sql);
		while ($rs1=mysql_fetch_array($res1)){
			$prih += $rs1["prihod"];
		} 
		$sql = "SELECT SUM(quant) as prihod FROM (sk_".$sklad."_dvizh_arc) JOIN sk_".$sklad."_spr ON (sk_".$sklad."_spr.id=sk_".$sklad."_dvizh_arc.spr_id) WHERE MONTH(ddate)=(FLOOR($month/10000)) AND YEAR(ddate)=($month%10000) AND sk_".$sklad."_spr.id='".$rs["id"]."' AND type='1' AND numd<>'9999' GROUP BY sk_".$sklad."_spr.id";
		$res1 = mysql_query($sql);
		while ($rs1=mysql_fetch_array($res1)){
			$prih += $rs1["prihod"];
		}
		$sql = "SELECT SUM(quant) as prihod FROM (sk_".$sklad."_dvizh) JOIN sk_".$sklad."_spr ON (sk_".$sklad."_spr.id=sk_".$sklad."_dvizh.spr_id) WHERE MONTH(ddate)=(FLOOR($month/10000)) AND YEAR(ddate)=($month%10000)  AND sk_".$sklad."_spr.id='".$rs["id"]."' AND type='0' AND numd<>'9999' GROUP BY sk_".$sklad."_spr.id";
		$res1 = mysql_query($sql);
		if ($rs1=mysql_fetch_array($res1)){
			$rash += $rs1["prihod"];
		} 
		$sql = "SELECT SUM(quant) as prihod FROM (sk_".$sklad."_dvizh_arc) JOIN sk_".$sklad."_spr ON (sk_".$sklad."_spr.id=sk_".$sklad."_dvizh_arc.spr_id) WHERE MONTH(ddate)=(FLOOR($month/10000)) AND YEAR(ddate)=($month%10000)  AND sk_".$sklad."_spr.id='".$rs["id"]."' AND type='0' AND numd<>'9999' GROUP BY sk_".$sklad."_spr.id";
		$res1 = mysql_query($sql);
		while ($rs1=mysql_fetch_array($res1)){
			$rash += $rs1["prihod"];
		}
		if (!empty($prih) || !empty($rash) || !empty($rs["ost"]) ) {
			if (!($i++%2)) 
				echo "<tr class='chettr'>";
			else 
				echo "<tr class='nechettr'>";		
			echo "<td>".$rs["nazv"]."<td>".sprintf("%10.2f",$prih)."<td>".sprintf("%10.2f",$rash)."<td>".$rs["ost"]."<td>".$rs["edizm"];

		}
	}
	echo "</table>";

?>