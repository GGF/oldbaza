<?
// ���������� �������������

include_once $GLOBALS["DOCUMENT_ROOT"]."/lib/sql.php"; 
authorize(); // ����� �����������


if (isset($edit) || isset($add) ) {
	// ������
} elseif (isset($delete)) {
	// ��������
}
else
{
// ������� �������
	// sql
		$sql="SELECT * FROM boards JOIN (customers) ON (customers.id=boards.customer_id) ".(isset($find)?"WHERE board_name LIKE '%$find%'":"").($order!=''?"ORDER BY ".$order." ":"ORDER BY board_name DESC ").(isset($all)?"LIMIT 50":"LIMIT 20");
	
	$cols[customer]="��������";
	$cols[board_name]="�����";
	$cols[sizex]="X";
	$cols[sizey]="Y";
	
	$addbutton=false;
	$type='plates';	
	include "table.php";
}
?>