<?php
include '..\..\config\koneksi.php';
if($_GET['act']=="edit") {
	$id = $_GET['id'];
	$namapro = $_POST['namapro'];
	$iddept = $_GET['iddept'];
	$query = pg_query("update proyek set namapro='$namapro' where idpro='$id'");
	$query1 = pg_query("update proyek set namapro='$namapro' where idpro='$id'");
	if(($query == true)&&($query1 == true)){
		header('location:..\..\media.php?module=proyek&iddept='.$iddept);
	}
	else{
		echo "Data gagal diedit";
	}
} else if($_GET['act']=="hapus") {
	$idpro = $_GET['id'];
	$iddept = $_GET['iddept'];
	$query = pg_query("delete from proyek where idpro =$idpro");
	if($query == true) {
		header('location:..\..\media.php?module=proyek&iddept='.$iddept);
	} else {
		echo "Data gagal hapus";
	}
} else if($_GET['act']=="tambah") {
	$namapro = $_POST['namapro'];
	$id = $_GET['id'];
	$iddept	= $_GET['iddept'];
	$query = pg_query("insert into proyek(idpro, namapro, iddept)values('$id','$namapro','$iddept')");
	if($query == true) {
		header('location:..\..\media.php?module=proyek&iddept='.$iddept);
	} else {
		echo "Data gagal tambah";
	}
}