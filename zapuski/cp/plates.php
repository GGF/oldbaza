<?
// управление мастерплатами

include_once $GLOBALS["DOCUMENT_ROOT"]."/lib/sql.php"; 
authorize(); // вызов авторизации


if (isset($edit) || isset($add) ) {
	// ничего
} elseif (isset($delete)) {
	// удаление
}
else
{
// вывести таблицу
	// sql
		$sql="SELECT * FROM boards JOIN (customers) ON (customers.id=boards.customer_id) ".(isset($find)?"WHERE board_name LIKE '%$find%'":"").($order!=''?"ORDER BY ".$order." ":"ORDER BY board_name DESC ").(isset($all)?"LIMIT 50":"LIMIT 20");
	
	$cols[customer]="Заказчик";
	$cols[board_name]="Плата";
	$cols[sizex]="X";
	$cols[sizey]="Y";
	
	$addbutton=false;
	$type='plates';	
	include "table.php";
}
?>