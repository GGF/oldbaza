<?

$GLOBALS["debugAPI"] = true;
include_once $GLOBALS["DOCUMENT_ROOT"]."/lib/sql.php"; // ��� ����� ��� ���������� ��� ��� �� ���������� �������� html

// ��������� ������������� ����������
$sql="SELECT id FROM coments WHERE comment='$comment'";
debug($sql);
$res = mysql_query($sql);
if ($rs=mysql_fetch_array($res)){
	$comment_id = $rs["id"];
} else {
	$sql="INSERT INTO coments (comment) VALUES ('$comment')";
	debug($sql);
	mysql_query($sql);
	$comment_id = mysql_insert_id();
	if (!$comment_id) my_error();
}

// �������� 
$sql="SELECT id FROM customers WHERE customer='$customer'";
debug($sql);
$res = mysql_query($sql);
if ($rs=mysql_fetch_array($res)){
	$customer_id = $rs["id"];
} else {
	$sql="INSERT INTO customers (customer) VALUES ('$customer')";
	print $sql;
	mysql_query($sql);
	$customer_id = mysql_insert_id();
	if (!$customer_id) exit;
}

// ��������� �����
$sql="SELECT id FROM boards WHERE customer_id='$customer_id' AND board_name='$board'";
debug($sql);
$res = mysql_query($sql);
if (!($rs=mysql_fetch_array($res))){
	$sql="INSERT INTO boards (id,board_name,customer_id,sizex,sizey,thickness,drawing_id,tex�olite,textolitepsi,thick_tol,rmark,frezcorner,layers,razr,pallad,immer,aurum,numlam,lsizex,lsizey,mask,mark,glasscloth,class,complexity_factor,frez_factor,comment_id) VALUES (NULL , '$board' ,'$customer_id' ,'$sizex' ,'$sizey' ,'$thickness' ,'$drawing_id' ,'$textolite' ,'$textolitepsi' ,'$thick_tol' ,'$rmark' ,'$frezcorner' ,'$layers' ,'$razr' ,'$pallad' ,'$immer' ,'$aurum' ,'$numlam' ,'$lsizex' ,'$lsizey' ,'$mask' ,'$mark' ,'$glasscloth' ,'$class' ,'$complexity_factor' ,'$frez_factor','$comment_id')";
	debug($sql);
	mysql_query($sql);
	$plate_id = mysql_insert_id();
} else {
	$plate_id = $rs["id"];
	mysql_query("DELETE FROM boards WHERE id='$plate_id'");
	$sql="INSERT INTO boards (id,board_name,customer_id,sizex,sizey,thickness,drawing_id,tex�olite,textolitepsi,thick_tol,rmark,frezcorner,layers,razr,pallad,immer,aurum,numlam,lsizex,lsizey,mask,mark,glasscloth,class,complexity_factor,frez_factor,comment_id) VALUES ('$plate_id' , '$board' ,'$customer_id' ,'$sizex' ,'$sizey' ,'$thickness' ,'$drawing_id' ,'$textolite' ,'$textolitepsi' ,'$thick_tol' ,'$rmark' ,'$frezcorner' ,'$layers' ,'$razr' ,'$pallad' ,'$immer' ,'$aurum' ,'$numlam' ,'$lsizex' ,'$lsizey' ,'$mask' ,'$mark' ,'$glasscloth' ,'$class' ,'$complexity_factor' ,'$frez_factor','$comment_id')";
	debug($sql);
	mysql_query($sql);
}
// ���������� �����
$sql="SELECT id,block_id FROM blockpos WHERE board_id='$plate_id'";
debug($sql);
$res = mysql_query($sql);
if (!($rs=mysql_fetch_array($res))){
	$sql = "SELECT id FROM blocks WHERE customer_id='$customer_id' AND blockname='$board'";
	debug($sql);
	$res = mysql_query($sql);
	if (!($rs=mysql_fetch_array($res))){
		$sql = "INSERT INTO blocks (id,customer_id,blockname,sizex,sizey,thickness,comment_id) VALUES(NULL,'$customer_id','$board','$bsizex','$bsizey','$thickness','$comment_id')";
		debug($sql);
		mysql_query($sql);
		$block_id = mysql_insert_id();
	} else {
		$block_id = $rs["id"];
		$sql="UPDATE blocks SET customer_id='$customer_id',blockname='$board',sizex='$bsizex',sizey='$bsizey',thickness='$thickness', comment_id='$comment_id' WHERE id='$block_id'";
		debug($sql);
		mysql_query($sql);
	}
	$sql = "INSERT INTO blockpos (block_id,board_id,nib,nx,ny) VALUES ('$block_id','$plate_id','$num','$bnx','$bny')";
	debug($sql);
	mysql_query($sql);
} else {
	$block_id = $rs["block_id"];
	$pib_id = $rs["id"];
	$sql="UPDATE blocks SET customer_id='$customer_id',blockname='$board',sizex='$bsizex',sizey='$bsizey',thickness='$thickness', comment_id='$comment_id' WHERE id='$block_id'";
	debug($sql);
	mysql_query($sql);
	$sql = "UPDATE blockpos SET block_id='$block_id',board_id='$plate_id',nib='$num',nx='$bnx',ny='$bny' WHERE id='$pib_id'";
	debug($sql);
	mysql_query($sql);
}


?>