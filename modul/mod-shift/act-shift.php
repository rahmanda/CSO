<?php
include '..\..\config\koneksi.php';
include '..\..\config\idshift_handle.php';
if($_GET['act']=="tambah") {
	$id = $data;
	$periode = $_POST['periode'];
	$query = pg_query("INSERT INTO shift(idshift, periode) values('$id','$periode')");
	if($query == true) {
		header('location:..\..\media.php?module=shift');
	} else {
		echo "Data gagal tambah";
	}
} else if($_GET['act']=="hapus") {
	$id = $_GET['id'];
	$query = pg_query("SELECT * FROM pegawai WHERE idshift='$id'");
	if(pg_num_rows($query) > 0) {
		header('location:..\..\media.php?module=shift&act=shifthandle&id='.$id);
	} else {
		$query = pg_query("DELETE FROM shift WHERE idshift='$id'");
		header('location:..\..\..\media.php?module=shift');
	}
} else if($_GET['act']=="shifthandle") {
	$old = $_GET['id'];
	$new = $_POST['shift'];
	$update = pg_query("UPDATE pegawai SET idshift='$new' WHERE idshift='$old'");
	$delete = pg_query("DELETE FROM shift WHERE idshift='$old'");
	if($delete == true) {
		header('location:..\..\..\media.php?module=shift');
	} else {
		echo "Data gagal hapus";
	}
} else if($_GET['act']=="edit") {
	$idshift = $_GET['id'];
	$new = $_POST['periode'];
	$update = pg_query("UPDATE shift SET periode='$new' WHERE idshift='$idshift'");
	if($update == true) {
		header('location:..\..\media.php?module=shift');
	} else {
		echo "Data gagal edit";
	}
}