<?
// ���������� ���������� �����

include_once $GLOBALS["DOCUMENT_ROOT"]."/lib/sql.php";
authorize(); // ����� �����������


if (isset($delete)) 
{
	// ������ ������� �������
	$sql="SELECT pos_in_tz_id FROM lanch WHERE id='$delete'";
	$rs=mysql_fetch_array(mysql_query($sql));
	$sql="UPDATE posintz SET ldate='0000-00-00' WHERE id='".$rs["pos_in_tz_id"]."'";
	mylog('posintz',$rs["pos_in_tz_id"],'UPDATE');
	mysql_query($sql);
	// ��������
	$sql = "DELETE FROM lanch WHERE id='$delete'";
	mylog('lanch',$delete);
	mysql_query($sql);
}
elseif (isset($show) || isset($edit) )
{
	$posid=isset($show)?$id:(isset($edit)?$edit:$add);
	$r = getright($user);
	//$sql="SELECT file_link FROM lanch JOIN (filelinks) ON (file_link_id=filelinks.id) WHERE lanch.id='$posid'";
	//echo $sql;
	//$rs=mysql_fetch_array(mysql_query($sql));
	//echo "<br><a onclick=\"window.open('zap.php?print=$posid')\" href='file://servermpp/".str_replace("\\","/",str_replace(":","",$rs[0]))."'>�� - $posid</a>";
	//echo "<a onclick=\"window.open('zap.php?print=$posid')\">�� - $posid</a><br>";
	echo "<a class=under href=zap.php?print=sl&id=$posid title='������� �� (��������� �����)'>�� - $posid</a><br>";
	//$sql="SELECT file_link,tz.id FROM posintz JOIN (lanch,tz,filelinks) ON (lanch.pos_in_tz_d=posintz.id AND tz.id=posintz.tz_id AND tz.file_link_id=filelinks.id) WHERE lanch.id='$posid'";
	$sql="SELECT tz.id FROM posintz JOIN (lanch,tz) ON (lanch.pos_in_tz_id=posintz.id AND tz.id=posintz.tz_id ) WHERE lanch.id='$posid'";
	//echo $sql;
	$rs=mysql_fetch_array(mysql_query($sql));
	//echo "<br><a onclick=\"window.open('zap.php?print=$posid')\" href='file://servermpp/".str_replace("\\","/",str_replace(":","",$rs[0]))."'>�� - $posid</a>";
	//echo "<a onclick=\"window.open('zap.php?print=tz&id=".$rs[0]."')\">�� - $rs[0]</a>";
	echo "<a class=under href=zap.php?print=tz&id=".$rs[0]." title='������� �� (��������� �����)'>�� - $rs[0]</a>";
	if ($r["zap"]["edit"]) {
		echo "<br>����������� <input id=dozap type=text size=2 name=dozap> ����";
		echo "<script>$('#dozap').keypress(function (e) {if (e.which==13) {
			//alert('� ��� ���!'+$('#dozap').attr('value'));
			editrecord('nzap','print=sl&dozap='+$('#dozap').val() + '&posid=$posid');
		}});</script>";
	}
	echo "<br><input type=button onclick='closeedit()' value='�������'>";
}
elseif (isset($print)) {
	if ($print=="tz") 
	{
		$print=$id;
		$sql="SELECT file_link FROM tz JOIN (filelinks) ON (tz.file_link_id=filelinks.id) WHERE tz.id='$print'";
		//echo $sql;
		$rs=mysql_fetch_array(mysql_query($sql));
		//echo str_replace("\\","/",str_replace(":","",$rs[0]));
		$filelink =  cp1251_to_utf8("/home/common/".str_replace("���������","���������",str_replace("\\","/",str_replace(":","",$rs[0]))));
		//echo $filelink;
		$file = file_get_contents($filelink);
		//echo $file;
		header("Content-type: application/vnd.ms-excel");
		//header("content-disposition: attachment;filename=mp.xml");
		echo $file;
	}
	elseif ($print=="sl")
	{
		$print = $id;
		$sql="SELECT file_link FROM lanch JOIN (filelinks) ON (file_link_id=filelinks.id) WHERE lanch.id='$print'";
		//echo $sql;
		$rs=mysql_fetch_array(mysql_query($sql));
		//echo str_replace("\\","/",str_replace(":","",$rs[0]));
		$filelink =  cp1251_to_utf8("/home/common/".str_replace("���������","���������",str_replace("\\","/",str_replace(":","",$rs[0]))));
		//echo $filelink;
		$file = file_get_contents($filelink);
		//echo $file;
		header("Content-type: application/vnd.ms-excel");
		//header("content-disposition: attachment;filename=mp.xml");
		echo $file;
	}
	
}
else
{
// ������� �������

	// sql
	$sql="SELECT *,tz.file_link_id as tzflid,IF(instr(fltz.file_link,'���')>0, '���', '���') AS type, lanch.id FROM lanch JOIN (users,filelinks,coments,plates,customers,tz,orders,filelinks as fltz) ON (lanch.user_id=users.id AND lanch.file_link_id=filelinks.id AND lanch.comment_id=coments.id AND lanch.board_id=plates.id AND plates.customer_id=customers.id AND lanch.tz_id=tz.id AND orders.id=tz.order_id AND tz.file_link_id=fltz.id)  ".(isset($find)?"AND (plates.plate LIKE '%$find%' OR fltz.file_link LIKE '%$find%' OR orders.number LIKE '%$find%' )":"").($order!=''?" ORDER BY ".$order." ":" ORDER BY lanch.id DESC ").(isset($all)?"LIMIT 50":"LIMIT 20");
	//$sql="SELECT *,posintz.id FROM posintz LEFT JOIN (lanch) ON (lanch.tz_id = posintz.tz_id AND lanch.pos_in_tz = posintz.posintz) LEFT JOIN (tmp) ON (posintz.plate_id=tmp.board_id) JOIN (plates,tz,filelinks,customers,orders) ON (tz.order_id=orders.id AND plates.id=posintz.plate_id  AND posintz.tz_id=tz.id AND tz.file_link_id=filelinks.id AND plates.customer_id=customers.id) WHERE posintz.tz_id != '0' AND lanch.id IS NULL ".(isset($find)?"AND (plates.plate LIKE '%$find%' OR filelinks.file_link LIKE '%$find%' OR orders.number LIKE '%$find%') ":"").($order!=''?"ORDER BY ".$order." ":"ORDER BY customers.customer,tz.id,posintz.id ").(isset($all)?"":"LIMIT 20");
	//echo $sql; exit;

	
	$type="zap";
	$cols["�"]="�";
	$cols[ldate]="����";
	$cols[type]="���";
	$cols[id]="ID";
	$cols[nik]="��������";
	$cols[customer]="��������";
	$cols[number]="�����";
	$cols[plate]="�����";
	$cols[part]="������";
	$cols[numbz]="���.";
	$cols[numbp]="����";
	//$cols[file_link]="����";
	
	$edit=false;
	$del=true;
	$addbutton=false;
	$opentype = "zap";

	include "table.php";

}

?>