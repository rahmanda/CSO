<?php
include '..\..\config\koneksi.php';
include '..\..\config\fungsi_thumb.php';
if ($_GET['module']=='profil' AND $_GET['act']=='edit'){
	$idpeg = $_GET['id'];
	$namadep = $_POST['namadep'];
	$namabel = $_POST['namabel'];
	$jk = $_POST['jk'];
	$alamat = $_POST['alamat'];
	$tgllahir = $_POST['tgllahir'];
	$telp = $_POST['notelp'];
	
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$nama_file = $namadep.".jpg";
	UploadUser($nama_file);
	$query = pg_query("update pegawai set namadep='$namadep', namabel='$namabel', jk='$jk', alamat='$alamat', tgllahir='$tgllahir', notlp='$telp' where idpeg='$idpeg'");
	
	header('location:..\..\media.php?module=profil');
}