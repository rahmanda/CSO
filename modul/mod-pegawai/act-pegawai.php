<?php
include '..\..\config\koneksi.php';
include '..\..\config\idpeg_handle.php';
if($_GET['act']=="edit") {
	$id = $_GET['id'];
	$namadep = $_POST['namadep'];
	$namabel = $_POST['namabel'];
	$jk = $_POST['jk'];
	$dept = $_POST['departemen'];
	$shift = $_POST['shift'];
	$alamat = $_POST['alamat'];
	$tgllahir = $_POST['tgllahir'];
	$telp = $_POST['notelp'];
	$status = $_POST['status'];
	$query = pg_query("update pegawai set namadep='$namadep', namabel='$namabel', jk='$jk', iddept='$dept', idshift='$shift', alamat='$alamat', tgllahir='$tgllahir', notlp='$telp', status='$status' where idpeg='$idpeg'");
	$query1 = pg_query("update pegawai set namadep='$namadep', namabel='$namabel', jk='$jk', iddept='$dept', idshift='$shift', alamat='$alamat', tgllahir='$tgllahir', notlp='$telp', status='$status' where idpeg='$id'");
	if(($query == true)&&($query1 == true)){
		header('location:..\..\media.php?module=pegawai');
	}
	else{
		echo "Data gagal diedit";
	}
} else if($_GET['act']=="hapus") {
	$id = $_GET['id'];
	$query = pg_query("SELECT * FROM departemen WHERE idmgr='$id'");
	if(pg_num_rows($query) > 0) {
		header('location:..\..\media.php?module=pegawai&act=mgrhandle&idmgr='.$id);
	} else {
		$query = pg_query("delete from pegawai where idpeg = '$id'");
		if($query == true) {
			header('location:..\..\media.php?module=pegawai');
		} else {
			echo "Data gagal hapus";
		}
	}
} else if($_GET['act']=="tambah") {
	$id = $data;
	$namadep = $_POST['namadep'];
	$namabel = $_POST['namabel'];
	$jk = $_POST['jk'];
	$dept = $_POST['departemen'];
	$shift = $_POST['shift'];
	$alamat = $_POST['alamat'];
	$tgllahir = $_POST['tgllahir'];
	$telp = $_POST['notelp'];
	$status = $_POST['status'];
	$query = pg_query("INSERT into PEGAWAI(idpeg, namadep, namabel, tgllahir, alamat, jk, notlp, iddept, idshift, status) values('$id','$namadep','$namabel','$tgllahir','$alamat','$jk','$telp','$dept','$shift','$status')");
	if($query == true) {
		header('location:..\..\media.php?module=pegawai');
	} else {
		echo "Data gagal tambah";
	}
} else if($_GET['act']=="mgrhandle") {
	$target = $_GET['target'];
	$id = $_POST['idpeg'];
	$dept = $_GET['iddept'];
	$swap = pg_query("UPDATE departemen SET idmgr='$id' WHERE iddept='$dept'");
	$delete = pg_query("DELETE FROM pegawai WHERE idpeg='$target'");
	if($delete == true) {
			header('location:..\..\..\media.php?module=pegawai');
	} else {
			echo "Data gagal hapus";
	}
}