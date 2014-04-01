<?php
include "koneksi.php";
$query = pg_query("SELECT * FROM pegawai ORDER BY idpeg DESC");
$data = pg_fetch_array($query);
$id = $data["idpeg"];
$split = str_split($id);
$array = array("$split[1]","$split[2]","$split[3]");
$join = implode($array);
$num = (int)$join;
$data = strval($num);
$data++;
if($num < 10) { 
	$zero = "00";
	$data = $zero.$data; 
} else if($num < 100) {
	$zero = "0";
	$data = $zero.$data;
}
$data = "P".$data;