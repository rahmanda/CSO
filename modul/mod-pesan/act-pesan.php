<?php
include '..\..\config\koneksi.php';
function email_handle($email) {
	$array = explode('@', $email);
	$get_identity = explode('_', $array[0]);
	return $get_identity[1];
}
if($_GET['act'] == "input") {
	$pengirim = $_GET['sender'];
	$penerima = email_handle($_POST['penerima']);
	$subjek = $_POST['subjek'];
	$pesan = $_POST['content-message'];
	$query = pg_query("INSERT INTO perpesanan(pengirim, penerima, subjek, isipesan, dibaca) VALUES('$pengirim', '$penerima', '$subjek', '$pesan', 'N')");
	if($query == true) {
		header('location:..\..\media.php?module=pesan');
	} else echo 'Gagal kirim pesan';
} else if($_GET['act'] == "hapus") {
	$tanggal = $_GET['time'];
	$query = pg_query("DELETE FROM perpesanan WHERE tanggal='$tanggal'");
	if($query == true) {
		header('location:..\..\media.php?module=pesan');
	} else echo 'Gagal hapus pesan';
}