<?
// ���������� �����������

include_once $GLOBALS["DOCUMENT_ROOT"]."/lib/sql.php";
authorize(); // ����� �����������


if (isset($edit) || isset($add) ) {
	if (!isset($accept)) {
		if ($edit) {
			$sql = "SELECT * FROM customers WHERE id='".$edit."'";
			$res = mysql_query($sql);
			$rs=mysql_fetch_array($res);
		}
		echo "<form method=post id=editform action='http://".$_SERVER['HTTP_HOST'].$GLOBALS["PHP_SELF"]."'>";
		echo "<input type='hidden' value='".(isset($edit)?$edit:"0")."' name='edit'>";
		echo "<input type=hidden name=tid value=$tid>";
		if (isset($order)) echo "<input type=hidden name=order value=$order>";
		if (isset($idstr)) echo "<input type=hidden name=idstr value=$idstr>";
		if (isset($find))echo "<input type=hidden name=find value=$find>";
		if (isset($all)) echo "<input type=hidden name=all value=$all>";
		echo "<input type=hidden name=accept value='yes'>";
		echo "������� �������� (��� ��������):<input type=text name=customer size=20 value='".$rs["customer"]."'><br>";
		echo "������ �������� (��� ����������): <input type=text name=fullname size=50 value='".$rs["fullname"]."'><br>";
		echo "������� �� ����� � (��� ���������): <input type=text name=kdir size=50 value='".$rs["kdir"]."'><br>";
		echo "<input type=button value='���������' onclick=\"editrecord('customers',$('#editform').serialize())\"><input type=button value='������' onclick='closeedit()'>";
	} else {
		// ���������
		if ($edit) {
			// ��������������
			$sql = "UPDATE customers SET customer='$customer', fullname='$fullname', kdir='$kdir' WHERE id='$edit'";
			mylog('customers',$edit,'UPDATE');
			mylog($sql);
		} else {
			// ����������
			$sql = "INSERT INTO customers (customer,fullname,kdir) VALUES ('$customer','$fullname','$kdir')";
			mylog($sql);
		}
		if (!mysql_query($sql)) {
			my_error("�� ������� ������ ��������� � ������� customers!!!");
		} else {
			echo "<script>updatetable('$tid','customers','');closeedit();</script>";
		}
	}
} elseif (isset($delete)) {
	// ��������
	$sql = "DELETE FROM customers WHERE id='$delete'";
	mylog('customers',$delete);
	mysql_query($sql);
	// �������� ������
	// ������� � ����� ���������
	$sql = "SELECT * FROM plates WHERE customer_id='$delete'";
	$res = mysql_query($sql);
	while ($rs=mysql_fetch_array($res)) {
		$sql = "DELETE FROM plates WHERE id='".$rs["id"]."'";
		mylog(plates,$rs["id"]);
		mysql_query($sql);
		// ���� �� ������� � ����� �.�.
	}
	// ������� �������� ������ � ��
	$sql = "SELECT * FROM orders WHERE customer_id='$delete'";
	$res2 = mysql_query($sql);
	while($rs2=mysql_fetch_array($res1)) {
		// ��������
		$delete = $rs2["id"];
		$sql = "DELETE FROM orders WHERE id='$delete'";
		mylog('orders',$delete);
		mysql_query($sql);
		
		// �������� ������
		$sql = "SELECT * FROM tz WHERE order_id='$delete'";
		$res1 = mysql_query($sql);
		while($rs1=mysql_fetch_array($res1)) {
			// ��������
			$delete = $rs1["id"];
			$sql = "DELETE FROM tz WHERE id='$delete'";
			mylog('tz',$delete);
			mysql_query($sql);
			// �������� ������
			$sql = "SELECT * FROM posintz WHERE tz_id='$delete'";
			$res = mysql_query($sql);
			while($rs=mysql_fetch_array($res)) {
				$delete = $rs["id"];
				$sql = "DELETE FROM posintz WHERE id='$delete'";
				mylog('posintz',$delete);
				mysql_query($sql);
			}
		}
	}
}
else
{
// ������� �������
	// sql
	$sql="SELECT * FROM customers ".(isset($find)?"WHERE (customers.customer LIKE '%$find%' OR customers.fullname LIKE '%$find%' ) ":"").(isset($order)?"ORDER BY ".$order." ":"ORDER BY customers.customer ").(isset($all)?"":"LIMIT 20");
	//print $sql;
	$type="customers";
	$cols[id]="ID";
	$cols[customer]="��������";
	$cols[fullname]="������ ��������";
	$cols[kdir]="���������";
	$del=true;
	$edit=true;
	$openfunc = "opencustr";
	$bgcolor='#FFFFFF';
	$title = '���������';
	
	include "table.php";
}
?>