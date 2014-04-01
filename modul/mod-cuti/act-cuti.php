<?php
include '..\..\config\koneksi.php';
if($_GET['act']=="edit") {
	$id = $_GET['id'];
	$mulaicuti = $_POST['mulaicuti'];
	$akhircuti = $_POST['akhircuti'];
	$status = $_POST['status'];
	$ket = $_POST['ket'];
	$query = pg_query("UPDATE cuti SET mulaicuti='$mulaicuti', akhircuti='$akhircuti', status='$status', keterangan='$ket' WHERE idpeg='$id'");
	if($query == true) {
		header('location:..\..\media.php?module=cuti');
	} else {
		echo "Gagal edit cuti";
	}
} else if($_GET['act']=="ajukan") {
	$id = $_GET['id'];
	$search = pg_query("SELECT * FROM pegawai WHERE idpeg='$id'");
	$fetch = pg_fetch_array($search);
	$iddept = $fetch['iddept'];
	$fetch = pg_fetch_array(pg_query("SELECT * FROM departemen WHERE iddept='$iddept'"));
	$idmgr = $fetch['idmgr'];
	$mulaicuti = $_POST['mulaicuti'];
	$akhircuti = $_POST['akhircuti'];
	$ket = $_POST['ket']; 
	$cuti = pg_query("INSERT INTO cuti(idpeg, mulaicuti, akhircuti, keterangan, status) values('$id','$mulaicuti','$akhircuti','$ket','P')");
	$update_status = pg_query("UPDATE pegawai SET status='Cuti' WHERE idpeg='$id'");
	$subjek = "Pengajuan Cuti";
	$pesan = "Pegawai dengan nomor id ".$id." mengajukan cuti dari tanggal ".$mulaicuti." sampai dengan ".$akhircuti;
	$send_message = pg_query("INSERT INTO perpesanan(pengirim, penerima, subjek, isipesan, dibaca) VALUES('$id','$idmgr','$subjek','$pesan','N')");
	if($cuti == true && $update_status == true && $send_message == true) {
		header('location:..\..\media.php?module=cuti');
	} else {
		echo "Gagal ajukan cuti";
	}
}