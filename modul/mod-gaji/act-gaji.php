<?php
include '..\..\config\koneksi.php';
if($_GET['act']=="edit") {
	$id = $_GET['id'];
	$gajipokok = $_POST['gajipokok'];
	$makan = $_POST['makan'];
	$tanggungan = $_POST['tanggungan'];
	$query = pg_query("update gaji set gajipokok='$gajipokok', makan='$makan', tanggungan='$tanggungan' where idpeg='$id'");
	$query1 = pg_query("update gaji set gajipokok='$gajipokok', makan='$makan', tanggungan='$tanggungan' where idpeg='$id'");
	if(($query == true)&&($query1 == true)){
		header('location:..\..\media.php?module=gaji');
	}
	else{
		echo "Data gagal diedit";
	}
}